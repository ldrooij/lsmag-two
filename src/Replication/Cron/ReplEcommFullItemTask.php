<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Replication\Cron;

use Ls\Replication\Logger\Logger;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Config\Model\ResourceModel\Config;
use Ls\Core\Helper\Data as LsHelper;
use Ls\Replication\Helper\ReplicationHelper;
use Ls\Omni\Client\Ecommerce\Entity\ReplRequest;
use Ls\Omni\Client\Ecommerce\Operation\ReplEcommFullItem;
use Ls\Replication\Api\LoyItemRepositoryInterface as LoyItemRepository;
use Ls\Replication\Model\LoyItemFactory;
use Ls\Replication\Api\Data\LoyItemInterface;

class ReplEcommFullItemTask extends AbstractReplicationTask
{
    public const JOB_CODE = 'replication_loy_item';

    public const CONFIG_PATH = 'ls_mag/replication/loy_item';

    public const CONFIG_PATH_STATUS = 'ls_mag/replication/status_loy_item';

    public const CONFIG_PATH_LAST_EXECUTE = 'ls_mag/replication/last_execute_loy_item';

    public const CONFIG_PATH_MAX_KEY = 'ls_mag/replication/max_key_loy_item';

    public const CONFIG_PATH_APP_ID = 'ls_mag/replication/app_id_loy_item';

    /**
     * @property LoyItemRepository $repository
     */
    protected $repository = null;

    /**
     * @property LoyItemFactory $factory
     */
    protected $factory = null;

    /**
     * @property LoyItemInterface $data_interface
     */
    protected $data_interface = null;

    /**
     * @param LoyItemRepository $repository
     * @return $this
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * @return LoyItemRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param LoyItemFactory $factory
     * @return $this
     */
    public function setFactory($factory)
    {
        $this->factory = $factory;
        return $this;
    }

    /**
     * @return LoyItemFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @param LoyItemInterface $data_interface
     * @return $this
     */
    public function setDataInterface($data_interface)
    {
        $this->data_interface = $data_interface;
        return $this;
    }

    /**
     * @return LoyItemInterface
     */
    public function getDataInterface()
    {
        return $this->data_interface;
    }

    public function __construct(ScopeConfigInterface $scope_config, Config $resource_config, Logger $logger, LsHelper $helper, ReplicationHelper $repHelper, LoyItemFactory $factory, LoyItemRepository $repository, LoyItemInterface $data_interface)
    {
        parent::__construct($scope_config, $resource_config, $logger, $helper, $repHelper);
        $this->repository = $repository;
        $this->factory = $factory;
        $this->data_interface = $data_interface;
    }

    public function makeRequest($lastKey, $fullReplication = false, $batchSize = 100, $storeId = '', $maxKey = '', $baseUrl = '', $appId = '')
    {
        $request = new ReplEcommFullItem($baseUrl);
        $request->getOperationInput()
                 ->setReplRequest( ( new ReplRequest() )->setBatchSize($batchSize)
                                                        ->setFullReplication($fullReplication)
                                                        ->setLastKey($lastKey)
                                                        ->setMaxKey($maxKey)
                                                        ->setStoreId($storeId)
                                                        ->setAppId($appId));
        return $request;
    }

    public function getConfigPath()
    {
        return self::CONFIG_PATH;
    }

    public function getConfigPathStatus()
    {
        return self::CONFIG_PATH_STATUS;
    }

    public function getConfigPathLastExecute()
    {
        return self::CONFIG_PATH_LAST_EXECUTE;
    }

    public function getConfigPathMaxKey()
    {
        return self::CONFIG_PATH_MAX_KEY;
    }

    public function getConfigPathAppId()
    {
        return self::CONFIG_PATH_APP_ID;
    }

    public function getMainEntity()
    {
        return $this->data_interface;
    }
}

