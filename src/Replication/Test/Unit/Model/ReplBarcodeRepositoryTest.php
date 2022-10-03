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
use \Ls\Replication\Model\ReplBarcodeRepository;
use \Ls\Replication\Model\ResourceModel\ReplBarcode\Collection;
use \Ls\Replication\Model\ResourceModel\ReplBarcode\CollectionFactory;
use \Ls\Replication\Api\ReplBarcodeRepositoryInterface;
use \Ls\Replication\Api\Data\ReplBarcodeInterface;
use \Ls\Replication\Api\Data\ReplBarcodeSearchResultsInterface;
use \Ls\Replication\Model\ReplBarcodeFactory;
use \Ls\Replication\Model\ReplBarcodeSearchResultsFactory;

class ReplBarcodeRepositoryTest extends TestCase
{
    /**
     * @property ReplBarcodeFactory $objectFactory
     */
    protected $objectFactory = null;

    /**
     * @property CollectionFactory $collectionFactory
     */
    protected $collectionFactory = null;

    /**
     * @property ReplBarcodeSearchResultsFactory $resultFactory
     */
    protected $resultFactory = null;

    /**
     * @property ReplBarcodeRepository $model
     */
    private $model = null;

    /**
     * @property ReplBarcodeInterface $entityInterface
     */
    private $entityInterface = null;

    /**
     * @property ReplBarcodeSearchResultsInterface $entitySearchResultsInterface
     */
    private $entitySearchResultsInterface = null;

    protected function setUp(): void
    {
        $this->objectFactory = $this->createPartialMock(ReplBarcodeFactory::class, ['create']);
        $this->collectionFactory = $this->createMock(CollectionFactory::class);
        $this->resultFactory = $this->createMock(ReplBarcodeSearchResultsFactory::class);
        $this->entityInterface = $this->createMock(ReplBarcodeInterface::class);
        $this->entitySearchResultsInterface = $this->createMock(ReplBarcodeSearchResultsInterface::class);
        $this->model = new ReplBarcodeRepository(
                $this->objectFactory,
                $this->collectionFactory,
                $this->resultFactory
        );
    }

    public function testGetById()
    {
        $entityId = 1;
        $entityMock = $this->createMock(ReplBarcodeRepository::class);
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
        $entityMock = $this->createMock(ReplBarcodeRepository::class);
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
        $entityMock = $this->createMock(ReplBarcodeRepository::class);
        $entityMock->method('getList')
             ->with($searchCriteria)
             ->willReturn($this->entitySearchResultsInterface);
        $this->assertEquals($this->entitySearchResultsInterface, $entityMock->getList($searchCriteria));
    }

    public function testSave()
    {
        $entityMock = $this->createMock(ReplBarcodeRepository::class);
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
        $entityMock = $this->createMock(ReplBarcodeRepository::class);
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

