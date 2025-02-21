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
use Ls\Omni\Client\Ecommerce\Operation\ReplEcommItemUnitOfMeasures;
use Ls\Replication\Api\ReplItemUnitOfMeasureRepositoryInterface as ReplItemUnitOfMeasureRepository;
use Ls\Replication\Model\ReplItemUnitOfMeasureFactory;
use Ls\Replication\Api\Data\ReplItemUnitOfMeasureInterface;

class ReplEcommItemUnitOfMeasuresTask extends AbstractReplicationTask
{
    public const JOB_CODE = 'replication_repl_item_unit_of_measure';

    public const CONFIG_PATH = 'ls_mag/replication/repl_item_unit_of_measure';

    public const CONFIG_PATH_STATUS = 'ls_mag/replication/status_repl_item_unit_of_measure';

    public const CONFIG_PATH_LAST_EXECUTE = 'ls_mag/replication/last_execute_repl_item_unit_of_measure';

    public const CONFIG_PATH_MAX_KEY = 'ls_mag/replication/max_key_repl_item_unit_of_measure';

    public const CONFIG_PATH_APP_ID = 'ls_mag/replication/app_id_repl_item_unit_of_measure';

    /**
     * @property ReplItemUnitOfMeasureRepository $repository
     */
    protected $repository = null;

    /**
     * @property ReplItemUnitOfMeasureFactory $factory
     */
    protected $factory = null;

    /**
     * @property ReplItemUnitOfMeasureInterface $data_interface
     */
    protected $data_interface = null;

    /**
     * @param ReplItemUnitOfMeasureRepository $repository
     * @return $this
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * @return ReplItemUnitOfMeasureRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param ReplItemUnitOfMeasureFactory $factory
     * @return $this
     */
    public function setFactory($factory)
    {
        $this->factory = $factory;
        return $this;
    }

    /**
     * @return ReplItemUnitOfMeasureFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @param ReplItemUnitOfMeasureInterface $data_interface
     * @return $this
     */
    public function setDataInterface($data_interface)
    {
        $this->data_interface = $data_interface;
        return $this;
    }

    /**
     * @return ReplItemUnitOfMeasureInterface
     */
    public function getDataInterface()
    {
        return $this->data_interface;
    }

    public function __construct(ScopeConfigInterface $scope_config, Config $resource_config, Logger $logger, LsHelper $helper, ReplicationHelper $repHelper, ReplItemUnitOfMeasureFactory $factory, ReplItemUnitOfMeasureRepository $repository, ReplItemUnitOfMeasureInterface $data_interface)
    {
        parent::__construct($scope_config, $resource_config, $logger, $helper, $repHelper);
        $this->repository = $repository;
        $this->factory = $factory;
        $this->data_interface = $data_interface;
    }

    public function makeRequest($lastKey, $fullReplication = false, $batchSize = 100, $storeId = '', $maxKey = '', $baseUrl = '', $appId = '')
    {
        $request = new ReplEcommItemUnitOfMeasures($baseUrl);
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

