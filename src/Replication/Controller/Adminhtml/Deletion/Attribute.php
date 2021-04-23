<?php

namespace Ls\Replication\Controller\Adminhtml\Deletion;

use Exception;
use \Ls\Core\Model\LSR;
use \Ls\Replication\Helper\ReplicationHelper;
use \Ls\Replication\Logger\Logger;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResourceConnection;

/**
 * Class Attribute Deletion
 */
class Attribute extends Action
{
    /**
     * @var Logger
     */
    public $logger;

    /** @var ResourceConnection */
    public $resource;

    /** @var LSR */
    public $lsr;

    /** @var ReplicationHelper */
    public $replicationHelper;

    // @codingStandardsIgnoreStart
    /** @var array */
    protected $_publicActions = ['attribute'];
    // @codingStandardsIgnoreEnd

    /** @var array List of ls tables required in attributes */
    public $ls_tables = [
        "ls_replication_repl_attribute",
        "ls_replication_repl_attribute_option_value",
        "ls_replication_repl_extended_variant_value"
    ];

    /**
     * Attribute constructor.
     * @param ResourceConnection $resource
     * @param Logger $logger
     * @param Context $context
     * @param LSR $LSR
     * @param ReplicationHelper $replicationHelper
     */
    public function __construct(
        ResourceConnection $resource,
        Logger $logger,
        Context $context,
        LSR $LSR,
        ReplicationHelper $replicationHelper
    ) {
        $this->resource          = $resource;
        $this->logger            = $logger;
        $this->lsr               = $LSR;
        $this->replicationHelper = $replicationHelper;
        parent::__construct($context);
    }

    /**
     * Remove Attributes
     *
     * @return void
     */
    public function execute()
    {
        // @codingStandardsIgnoreStart
        $connection = $this->resource->getConnection(ResourceConnection::DEFAULT_CONNECTION);
        $tableName  = $this->resource->getTableName('eav_attribute');
        $query      = "DELETE FROM $tableName WHERE attribute_code LIKE 'ls\_%'";
        try {
            $connection->query($query);
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
        // Update all dependent ls tables to not processed
        foreach ($this->ls_tables as $lsTable) {
            $lsTableName = $this->resource->getTableName($lsTable);
            $lsQuery     = 'UPDATE ' . $lsTableName . ' SET processed = 0, is_updated = 0, is_failed = 0, processed_at = NULL;';
            try {
                $connection->query($lsQuery);
            } catch (Exception $e) {
                $this->logger->debug($e->getMessage());
            }
        }
        // Reset Data Translation Table for attributes
        $lsTableName = $this->resource->getTableName("ls_replication_repl_data_translation");
        $lsQuery     = 'UPDATE ' . $lsTableName . ' SET processed = 0, is_updated = 0, is_failed = 0,
            processed_at = NULL WHERE TranslationId ="' . LSR::SC_TRANSLATION_ID_ATTRIBUTE_OPTION_VALUE . '" OR TranslationId ="' . LSR::SC_TRANSLATION_ID_ATTRIBUTE . '"';
        try {
            $connection->query($lsQuery);
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
        $this->replicationHelper->updateCronStatusForAllStores(
            false,
            LSR::SC_SUCCESS_CRON_ATTRIBUTE
        );
        $this->replicationHelper->updateCronStatusForAllStores(
            false,
            LSR::SC_SUCCESS_CRON_ATTRIBUTE_VARIANT
        );
        $this->replicationHelper->updateCronStatusForAllStores(
            false,
            LSR::SC_SUCCESS_CRON_DATA_TRANSLATION_TO_MAGENTO
        );
        // @codingStandardsIgnoreEnd
        $this->messageManager->addSuccessMessage(__('LS Attributes deleted successfully.'));
        $this->_redirect('adminhtml/system_config/edit/section/ls_mag');
    }
}
