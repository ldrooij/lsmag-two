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
use \Ls\Replication\Model\ReplHierarchyRepository;
use \Ls\Replication\Model\ResourceModel\ReplHierarchy\Collection;
use \Ls\Replication\Model\ResourceModel\ReplHierarchy\CollectionFactory;
use \Ls\Replication\Api\ReplHierarchyRepositoryInterface;
use \Ls\Replication\Api\Data\ReplHierarchyInterface;
use \Ls\Replication\Api\Data\ReplHierarchySearchResultsInterface;
use \Ls\Replication\Model\ReplHierarchyFactory;
use \Ls\Replication\Model\ReplHierarchySearchResultsFactory;

class ReplHierarchyRepositoryTest extends TestCase
{
    /**
     * @property ReplHierarchyFactory $objectFactory
     */
    protected $objectFactory = null;

    /**
     * @property CollectionFactory $collectionFactory
     */
    protected $collectionFactory = null;

    /**
     * @property ReplHierarchySearchResultsFactory $resultFactory
     */
    protected $resultFactory = null;

    /**
     * @property ReplHierarchyRepository $model
     */
    private $model = null;

    /**
     * @property ReplHierarchyInterface $entityInterface
     */
    private $entityInterface = null;

    /**
     * @property ReplHierarchySearchResultsInterface $entitySearchResultsInterface
     */
    private $entitySearchResultsInterface = null;

    protected function setUp(): void
    {
        $this->objectFactory = $this->createPartialMock(ReplHierarchyFactory::class, ['create']);
        $this->collectionFactory = $this->createMock(CollectionFactory::class);
        $this->resultFactory = $this->createMock(ReplHierarchySearchResultsFactory::class);
        $this->entityInterface = $this->createMock(ReplHierarchyInterface::class);
        $this->entitySearchResultsInterface = $this->createMock(ReplHierarchySearchResultsInterface::class);
        $this->model = new ReplHierarchyRepository(
                $this->objectFactory,
                $this->collectionFactory,
                $this->resultFactory
        );
    }

    public function testGetById()
    {
        $entityId = 1;
        $entityMock = $this->createMock(ReplHierarchyRepository::class);
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
        $entityMock = $this->createMock(ReplHierarchyRepository::class);
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
        $entityMock = $this->createMock(ReplHierarchyRepository::class);
        $entityMock->method('getList')
             ->with($searchCriteria)
             ->willReturn($this->entitySearchResultsInterface);
        $this->assertEquals($this->entitySearchResultsInterface, $entityMock->getList($searchCriteria));
    }

    public function testSave()
    {
        $entityMock = $this->createMock(ReplHierarchyRepository::class);
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
        $entityMock = $this->createMock(ReplHierarchyRepository::class);
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

