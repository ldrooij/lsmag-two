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
use Ls\Omni\Client\Ecommerce\Operation\ReplEcommTaxSetup;
use Ls\Replication\Api\ReplTaxSetupRepositoryInterface as ReplTaxSetupRepository;
use Ls\Replication\Model\ReplTaxSetupFactory;
use Ls\Replication\Api\Data\ReplTaxSetupInterface;

class ReplEcommTaxSetupTask extends AbstractReplicationTask
{

    const JOB_CODE = 'replication_repl_tax_setup';

    const CONFIG_PATH = 'ls_mag/replication/repl_tax_setup';

    const CONFIG_PATH_STATUS = 'ls_mag/replication/status_repl_tax_setup';

    const CONFIG_PATH_LAST_EXECUTE = 'ls_mag/replication/last_execute_repl_tax_setup';

    /**
     * @property ReplTaxSetupRepository $repository
     */
    protected $repository = null;

    /**
     * @property ReplTaxSetupFactory $factory
     */
    protected $factory = null;

    /**
     * @property ReplTaxSetupInterface $data_interface
     */
    protected $data_interface = null;

    /**
     * @param ReplTaxSetupRepository $repository
     * @return $this
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * @return ReplTaxSetupRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param ReplTaxSetupFactory $factory
     * @return $this
     */
    public function setFactory($factory)
    {
        $this->factory = $factory;
        return $this;
    }

    /**
     * @return ReplTaxSetupFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @param ReplTaxSetupInterface $data_interface
     * @return $this
     */
    public function setDataInterface($data_interface)
    {
        $this->data_interface = $data_interface;
        return $this;
    }

    /**
     * @return ReplTaxSetupInterface
     */
    public function getDataInterface()
    {
        return $this->data_interface;
    }

    public function __construct(ScopeConfigInterface $scope_config, Config $resource_config, Logger $logger, LsHelper $helper, ReplicationHelper $repHelper, ReplTaxSetupFactory $factory, ReplTaxSetupRepository $repository, ReplTaxSetupInterface $data_interface)
    {
        parent::__construct($scope_config, $resource_config, $logger, $helper, $repHelper);
        $this->repository = $repository;
        $this->factory = $factory;
        $this->data_interface = $data_interface;
    }

    public function makeRequest($last_key, $full_replication = false, $batchsize = 100, $storeId = '')
    {
        $request = new ReplEcommTaxSetup();
        $request->getOperationInput()
                 ->setReplRequest( ( new ReplRequest() )->setBatchSize($batchsize)
                                                        ->setFullReplication($full_replication)
                                                        ->setLastKey($last_key)
                                                        ->setStoreId($storeId));
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

    public function getMainEntity()
    {
        return $this->data_interface;
    }


}

