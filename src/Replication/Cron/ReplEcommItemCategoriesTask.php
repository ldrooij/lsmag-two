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
use Ls\Omni\Client\Ecommerce\Operation\ReplEcommItemCategories;
use Ls\Replication\Api\ReplItemCategoryRepositoryInterface as ReplItemCategoryRepository;
use Ls\Replication\Model\ReplItemCategoryFactory;
use Ls\Replication\Api\Data\ReplItemCategoryInterface;

class ReplEcommItemCategoriesTask extends AbstractReplicationTask
{
    public const JOB_CODE = 'replication_repl_item_category';

    public const CONFIG_PATH = 'ls_mag/replication/repl_item_category';

    public const CONFIG_PATH_STATUS = 'ls_mag/replication/status_repl_item_category';

    public const CONFIG_PATH_LAST_EXECUTE = 'ls_mag/replication/last_execute_repl_item_category';

    public const CONFIG_PATH_MAX_KEY = 'ls_mag/replication/max_key_repl_item_category';

    public const CONFIG_PATH_APP_ID = 'ls_mag/replication/app_id_repl_item_category';

    /**
     * @property ReplItemCategoryRepository $repository
     */
    protected $repository = null;

    /**
     * @property ReplItemCategoryFactory $factory
     */
    protected $factory = null;

    /**
     * @property ReplItemCategoryInterface $data_interface
     */
    protected $data_interface = null;

    /**
     * @param ReplItemCategoryRepository $repository
     * @return $this
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * @return ReplItemCategoryRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param ReplItemCategoryFactory $factory
     * @return $this
     */
    public function setFactory($factory)
    {
        $this->factory = $factory;
        return $this;
    }

    /**
     * @return ReplItemCategoryFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @param ReplItemCategoryInterface $data_interface
     * @return $this
     */
    public function setDataInterface($data_interface)
    {
        $this->data_interface = $data_interface;
        return $this;
    }

    /**
     * @return ReplItemCategoryInterface
     */
    public function getDataInterface()
    {
        return $this->data_interface;
    }

    public function __construct(ScopeConfigInterface $scope_config, Config $resource_config, Logger $logger, LsHelper $helper, ReplicationHelper $repHelper, ReplItemCategoryFactory $factory, ReplItemCategoryRepository $repository, ReplItemCategoryInterface $data_interface)
    {
        parent::__construct($scope_config, $resource_config, $logger, $helper, $repHelper);
        $this->repository = $repository;
        $this->factory = $factory;
        $this->data_interface = $data_interface;
    }

    public function makeRequest($lastKey, $fullReplication = false, $batchSize = 100, $storeId = '', $maxKey = '', $baseUrl = '', $appId = '')
    {
        $request = new ReplEcommItemCategories($baseUrl);
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

