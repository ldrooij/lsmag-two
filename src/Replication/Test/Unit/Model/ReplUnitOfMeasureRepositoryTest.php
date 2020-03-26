<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Replication\Test\Unit\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;
use Exception;
use Magento\Framework\Phrase;
use Magento\Framework\Api\SortOrder;
use PHPUnit\Framework\TestCase;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use \Ls\Replication\Model\ReplUnitOfMeasureRepository;
use \Ls\Replication\Model\ResourceModel\ReplUnitOfMeasure\Collection;
use \Ls\Replication\Model\ResourceModel\ReplUnitOfMeasure\CollectionFactory;
use \Ls\Replication\Api\ReplUnitOfMeasureRepositoryInterface;
use \Ls\Replication\Api\Data\ReplUnitOfMeasureInterface;
use \Ls\Replication\Api\Data\ReplUnitOfMeasureSearchResultsInterface;
use \Ls\Replication\Model\ReplUnitOfMeasureFactory;
use \Ls\Replication\Model\ReplUnitOfMeasureSearchResultsFactory;

class ReplUnitOfMeasureRepositoryTest extends TestCase
{

    /**
     * @property ReplUnitOfMeasureFactory $objectFactory
     */
    protected $objectFactory = null;

    /**
     * @property CollectionFactory $collectionFactory
     */
    protected $collectionFactory = null;

    /**
     * @property ReplUnitOfMeasureSearchResultsFactory $resultFactory
     */
    protected $resultFactory = null;

    /**
     * @property ReplUnitOfMeasureRepository $model
     */
    private $model = null;

    /**
     * @property ReplUnitOfMeasureInterface $entityInterface
     */
    private $entityInterface = null;

    /**
     * @property ReplUnitOfMeasureSearchResultsInterface $entitySearchResultsInterface
     */
    private $entitySearchResultsInterface = null;

    public function setUp()
    {
        $this->objectFactory = $this->createPartialMock(ReplUnitOfMeasureFactory::class, ['create']);
        $this->collectionFactory = $this->createMock(CollectionFactory::class);
        $this->resultFactory = $this->createMock(ReplUnitOfMeasureSearchResultsFactory::class);
        $this->entityInterface = $this->createMock(ReplUnitOfMeasureInterface::class);
        $this->entitySearchResultsInterface = $this->createMock(ReplUnitOfMeasureSearchResultsInterface::class);
        $this->model = new ReplUnitOfMeasureRepository(
                $this->objectFactory,
                $this->collectionFactory,
                $this->resultFactory
        );
    }

    public function testGetById()
    {
        $entityId = 1;
        $entityMock = $this->createMock(ReplUnitOfMeasureRepository::class);
        $entityMock->method('getById')
             ->with($entityId)
             ->willReturn($entityId);
        $this->assertEquals($entityId, $entityMock->getById($entityId));
    }

    /**
     * @expectedException \Magento\Framework\Exception\NoSuchEntityException 
     * @expectedExceptionMessage Object with id 1 does not exist.
     */
    public function testGetWithNoSuchEntityException()
    {
        $entityId = 1;
        $entityMock = $this->createMock(ReplUnitOfMeasureRepository::class);
        $entityMock->method('getById')
             ->with($entityId)
             ->willThrowException(
                 new NoSuchEntityException(
                     new Phrase('Object with id ' . $entityId . ' does not exist.')
                 )
             );
        $entityMock->getById($entityId);
    }

    public function testGetListWithSearchCriteria()
    {
        $searchCriteria = $this->getMockBuilder(SearchCriteriaInterface::class)->getMock();
        $entityMock = $this->createMock(ReplUnitOfMeasureRepository::class);
        $entityMock->method('getList')
             ->with($searchCriteria)
             ->willReturn($this->entitySearchResultsInterface);
        $this->assertEquals($this->entitySearchResultsInterface, $entityMock->getList($searchCriteria));
    }

    public function testSave()
    {
        $entityMock = $this->createMock(ReplUnitOfMeasureRepository::class);
        $entityMock->method('save')
             ->with($this->entityInterface)
             ->willReturn($this->entityInterface);
        $this->assertEquals($this->entityInterface, $entityMock->save($this->entityInterface));
    }

    /**
     * @expectedException \Magento\Framework\Exception\CouldNotSaveException 
     * @expectedExceptionMessage Could not save entity
     */
    public function testSaveWithCouldNotSaveException()
    {
        $entityMock = $this->createMock(ReplUnitOfMeasureRepository::class);
        $entityMock->method('save')
             ->with($this->entityInterface)
             ->willThrowException(
                 new CouldNotSaveException(
                     __('Could not save entity')
                 )
             );
        $entityMock->save($this->entityInterface);
    }


}

