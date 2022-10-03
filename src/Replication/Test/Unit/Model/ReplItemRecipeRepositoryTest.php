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
use \Ls\Replication\Model\ReplItemRecipeRepository;
use \Ls\Replication\Model\ResourceModel\ReplItemRecipe\Collection;
use \Ls\Replication\Model\ResourceModel\ReplItemRecipe\CollectionFactory;
use \Ls\Replication\Api\ReplItemRecipeRepositoryInterface;
use \Ls\Replication\Api\Data\ReplItemRecipeInterface;
use \Ls\Replication\Api\Data\ReplItemRecipeSearchResultsInterface;
use \Ls\Replication\Model\ReplItemRecipeFactory;
use \Ls\Replication\Model\ReplItemRecipeSearchResultsFactory;

class ReplItemRecipeRepositoryTest extends TestCase
{
    /**
     * @property ReplItemRecipeFactory $objectFactory
     */
    protected $objectFactory = null;

    /**
     * @property CollectionFactory $collectionFactory
     */
    protected $collectionFactory = null;

    /**
     * @property ReplItemRecipeSearchResultsFactory $resultFactory
     */
    protected $resultFactory = null;

    /**
     * @property ReplItemRecipeRepository $model
     */
    private $model = null;

    /**
     * @property ReplItemRecipeInterface $entityInterface
     */
    private $entityInterface = null;

    /**
     * @property ReplItemRecipeSearchResultsInterface $entitySearchResultsInterface
     */
    private $entitySearchResultsInterface = null;

    protected function setUp(): void
    {
        $this->objectFactory = $this->createPartialMock(ReplItemRecipeFactory::class, ['create']);
        $this->collectionFactory = $this->createMock(CollectionFactory::class);
        $this->resultFactory = $this->createMock(ReplItemRecipeSearchResultsFactory::class);
        $this->entityInterface = $this->createMock(ReplItemRecipeInterface::class);
        $this->entitySearchResultsInterface = $this->createMock(ReplItemRecipeSearchResultsInterface::class);
        $this->model = new ReplItemRecipeRepository(
                $this->objectFactory,
                $this->collectionFactory,
                $this->resultFactory
        );
    }

    public function testGetById()
    {
        $entityId = 1;
        $entityMock = $this->createMock(ReplItemRecipeRepository::class);
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
        $entityMock = $this->createMock(ReplItemRecipeRepository::class);
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
        $entityMock = $this->createMock(ReplItemRecipeRepository::class);
        $entityMock->method('getList')
             ->with($searchCriteria)
             ->willReturn($this->entitySearchResultsInterface);
        $this->assertEquals($this->entitySearchResultsInterface, $entityMock->getList($searchCriteria));
    }

    public function testSave()
    {
        $entityMock = $this->createMock(ReplItemRecipeRepository::class);
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
        $entityMock = $this->createMock(ReplItemRecipeRepository::class);
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

