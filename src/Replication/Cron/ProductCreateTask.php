<?php

namespace Ls\Replication\Cron;

use Exception;
use \Ls\Core\Model\LSR;
use \Ls\Omni\Helper\LoyaltyHelper;
use \Ls\Omni\Helper\StockHelper;
use \Ls\Replication\Api\ReplAttributeValueRepositoryInterface;
use \Ls\Replication\Api\ReplLoyVendorItemMappingRepositoryInterface;
use \Ls\Replication\Api\ReplBarcodeRepositoryInterface as ReplBarcodeRepository;
use \Ls\Replication\Api\ReplExtendedVariantValueRepositoryInterface as ReplExtendedVariantValueRepository;
use \Ls\Replication\Api\ReplHierarchyLeafRepositoryInterface as ReplHierarchyLeafRepository;
use \Ls\Replication\Api\ReplImageLinkRepositoryInterface;
use \Ls\Replication\Api\ReplImageRepositoryInterface as ReplImageRepository;
use \Ls\Replication\Api\ReplInvStatusRepositoryInterface as ReplInvStatusRepository;
use \Ls\Replication\Api\ReplItemRepositoryInterface as ReplItemRepository;
use \Ls\Replication\Api\ReplItemUnitOfMeasureRepositoryInterface as ReplItemUnitOfMeasure;
use \Ls\Replication\Api\ReplItemVariantRegistrationRepositoryInterface as ReplItemVariantRegistrationRepository;
use \Ls\Replication\Api\ReplPriceRepositoryInterface as ReplPriceRepository;
use \Ls\Replication\Helper\ReplicationHelper;
use \Ls\Replication\Logger\Logger;
use \Ls\Replication\Model\ReplAttributeValue;
use \Ls\Replication\Model\ReplAttributeValueSearchResults;
use \Ls\Replication\Model\ReplBarcode;
use \Ls\Replication\Model\ReplBarcodeSearchResults;
use \Ls\Replication\Model\ReplExtendedVariantValue;
use \Ls\Replication\Model\ReplImageLink;
use \Ls\Replication\Model\ReplInvStatus;
use \Ls\Replication\Model\ReplItem;
use \Ls\Replication\Model\ReplItemSearchResults;
use \Ls\Replication\Model\ReplItemUnitOfMeasureSearchResultsFactory;
use \Ls\Replication\Model\ReplItemVariantRegistration;
use \Ls\Replication\Model\ResourceModel\ReplAttributeValue\CollectionFactory as ReplAttributeValueCollectionFactory;
use \Ls\Replication\Model\ResourceModel\ReplLoyVendorItemMapping\CollectionFactory as ReplItemVendorCollectionFactory;
use \Ls\Replication\Model\ResourceModel\ReplExtendedVariantValue\CollectionFactory as ReplExtendedVariantValueCollectionFactory;
use \Ls\Replication\Model\ResourceModel\ReplHierarchyLeaf\CollectionFactory as ReplHierarchyLeafCollectionFactory;
use \Ls\Replication\Model\ResourceModel\ReplImageLink\CollectionFactory as ReplImageLinkCollectionFactory;
use \Ls\Replication\Model\ResourceModel\ReplInvStatus\CollectionFactory as ReplInvStatusCollectionFactory;
use \Ls\Replication\Model\ResourceModel\ReplItemUnitOfMeasure\CollectionFactory as ReplItemUomCollectionFactory;
use \Ls\Replication\Model\ResourceModel\ReplPrice\CollectionFactory as ReplPriceCollectionFactory;
use Magento\Catalog\Api\AttributeSetRepositoryInterface;
use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Api\CategoryLinkRepositoryInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\Data\ProductAttributeMediaGalleryEntryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Attribute\Backend\Media\EntryConverterPool;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Gallery\Processor;
use Magento\Catalog\Model\Product\Gallery\UpdateHandler;
use Magento\Catalog\Model\Product\Type;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ProductRepository\MediaGalleryProcessor;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute\Interceptor;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\CatalogInventory\Model\Stock\Item;
use Magento\ConfigurableProduct\Api\Data\OptionInterface;
use Magento\ConfigurableProduct\Helper\Product\Options\Factory;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable as ConfigurableProTypeModel;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable\Attribute;
use Magento\Eav\Api\AttributeGroupRepositoryInterface;
use Magento\Eav\Model\AttributeManagement;
use Magento\Eav\Model\AttributeSetManagement;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Attribute\GroupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory;
use Magento\Eav\Model\Entity\TypeFactory;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\CollectionFactory as EavAttributeCollectionFactory;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\ImageContentFactory;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\StateException;
use Magento\Store\Api\Data\StoreInterface;

/**
 * Create Items in magento
 * replicated from omni
 */
class ProductCreateTask
{
    /** @var Factory */
    public $factory;

    /** @var Item */
    public $item;

    /** @var Config */
    public $eavConfig;

    /** @var Configurable */
    public $configurable;

    /** @var Attribute */
    public $attribute;

    /** @var ProductInterfaceFactory */
    public $productFactory;

    /** @var ProductRepositoryInterface */
    public $productRepository;

    /** @var CollectionFactory */
    public $categoryCollectionFactory;

    /** @var CategoryLinkManagementInterface */
    public $categoryLinkManagement;

    /** @var ReplItemRepository */
    public $itemRepository;

    /** @var ReplExtendedVariantValueRepository */
    public $extendedVariantValueRepository;

    /** @var ReplImageRepository */
    public $imageRepository;

    /** @var ReplBarcodeRepository */
    public $replBarcodeRepository;

    /** @var ReplImageLinkRepositoryInterface */
    public $replImageLinkRepositoryInterface;

    /** @var ReplHierarchyLeafRepository */
    public $replHierarchyLeafRepository;

    /** @var ReplPriceRepository */
    public $replPriceRepository;

    /** @var ReplItemUnitOfMeasure */
    public $replItemUomRepository;

    /** @var ReplInvStatusRepository */
    public $replInvStatusRepository;

    /** @var ProductAttributeMediaGalleryEntryInterface */
    public $attributeMediaGalleryEntry;

    /** @var ImageContentFactory */
    public $imageContent;

    /** @var SearchCriteriaBuilder */
    public $searchCriteriaBuilder;

    /** @var SortOrderBuilder */
    public $sortOrder;

    /** @var FilterBuilder */
    public $filterBuilder;

    /** @var FilterGroupBuilder */
    public $filterGroupBuilder;

    /** @var Logger */
    public $logger;

    /** @var LoyaltyHelper */
    public $loyaltyHelper;

    /** @var ReplicationHelper */
    public $replicationHelper;

    /** @var ReplAttributeValueRepositoryInterface */
    public $replAttributeValueRepositoryInterface;

    /** @var LSR */
    public $lsr;

    /** @var bool */
    public $cronStatus = false;

    /** @var StockHelper */
    public $stockHelper;

    /** @var ReplItemVariantRegistrationRepository */
    public $replItemVariantRegistrationRepository;

    /** @var ConfigurableProTypeModel */
    public $configurableProTypeModel;

    /**  @var ReplInvStatusCollectionFactory */
    public $replInvStatusCollectionFactory;

    /** @var ReplPriceCollectionFactory */
    public $replPriceCollectionFactory;

    /** @var ReplItemUomCollectionFactory */
    public $replItemUomCollectionFactory;

    /** @var ReplHierarchyLeafCollectionFactory */
    public $replHierarchyLeafCollectionFactory;

    /** @var ReplImageLinkCollectionFactory */
    public $replImageLinkCollectionFactory;

    /**  @var ReplAttributeValueCollectionFactory */
    public $replAttributeValueCollectionFactory;

    /**  @var ReplExtendedVariantValueCollectionFactory */
    public $replExtendedVariantValueCollectionFactory;

    /** @var \Magento\Catalog\Model\ResourceModel\Product */
    public $productResourceModel;

    /** @var StockRegistryInterface */
    public $stockRegistry;

    /** @var CategoryLinkRepositoryInterface */
    public $categoryLinkRepositoryInterface;

    /** @var CollectionFactory */
    public $collectionFactory;

    /** @var CategoryRepositoryInterface */
    public $categoryRepository;

    /** @var Processor */
    public $imageProcessor;

    /** @var int */
    public $remainingRecords;

    /**
     * @var MediaGalleryProcessor
     */
    public $mediaGalleryProcessor;

    /**
     * @var UpdateHandler
     */
    public $updateHandler;
    /**
     * @var EntryConverterPool
     */
    public $entryConverterPool;

    /** @var StoreInterface $store */
    public $store;

    /** @var int|bool */
    public $webStoreId = false;

    /**
     * @var Factory
     */
    public $optionsFactory;

    /**
     * @var AttributeSetRepositoryInterface
     */
    public $attributeSetRepository;

    /**
     * @var TypeFactory
     */
    public $eavTypeFactory;

    /**
     * @var SetFactory
     */
    public $attributeSetFactory;

    /**
     * @var AttributeManagement
     */
    public $attributeManagement;

    /**
     * @var AttributeSetManagement
     */
    public $attributeSetManagement;

    /**
     * @var GroupFactory
     */
    public $attributeSetGroupFactory;

    public $attributeGroupRepository;

    /**
     * @var ReplItemUnitOfMeasureSearchResultsFactory
     */
    public $replItemUnitOfMeasureSearchResultsFactory;

    /**
     * @var EavAttributeCollectionFactory
     */
    public $eavAttributeCollectionFactory;

    /**
     * @var ReplItemVendorCollectionFactory
     */
    public $replItemVendorCollectionFactory;

    /**
     * @var ReplLoyVendorItemMappingRepositoryInterface
     */
    public $replVendorItemMappingRepositoryInterface;

    /**
     * ProductCreateTask constructor.
     * @param Factory $factory
     * @param Item $item
     * @param Config $eavConfig
     * @param ConfigurableProTypeModel $configurable
     * @param Attribute $attribute
     * @param ProductInterfaceFactory $productInterfaceFactory
     * @param ProductRepositoryInterface $productRepository
     * @param ProductAttributeMediaGalleryEntryInterface $attributeMediaGalleryEntry
     * @param ImageContentFactory $imageContent
     * @param CollectionFactory $categoryCollectionFactory
     * @param CategoryLinkManagementInterface $categoryLinkManagement
     * @param ReplItemRepository $itemRepository
     * @param ReplItemVariantRegistrationRepository $replItemVariantRegistrationRepository
     * @param ReplExtendedVariantValueRepository $extendedVariantValueRepository
     * @param ReplImageRepository $replImageRepository
     * @param ReplHierarchyLeafRepository $replHierarchyLeafRepository
     * @param ReplBarcodeRepository $replBarcodeRepository
     * @param ReplPriceRepository $replPriceRepository
     * @param ReplItemUnitOfMeasure $replItemUnitOfMeasureRepository
     * @param ReplInvStatusRepository $replInvStatusRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrder $sortOrder
     * @param FilterBuilder $filterBuilder
     * @param FilterGroupBuilder $filterGroupBuilder
     * @param ReplImageLinkRepositoryInterface $replImageLinkRepositoryInterface
     * @param LoyaltyHelper $loyaltyHelper
     * @param ReplicationHelper $replicationHelper
     * @param ReplAttributeValueRepositoryInterface $replAttributeValueRepositoryInterface
     * @param ReplLoyVendorItemMappingRepositoryInterface $replVendorItemMappingRepositoryInterface
     * @param Logger $logger
     * @param LSR $LSR
     * @param ConfigurableProTypeModel $configurableProTypeModel
     * @param StockHelper $stockHelper
     * @param ReplInvStatusCollectionFactory $replInvStatusCollectionFactory
     * @param ReplPriceCollectionFactory $replPriceCollectionFactory
     * @param ReplItemUomCollectionFactory $replItemUomCollectionFactory
     * @param ReplHierarchyLeafCollectionFactory $replHierarchyLeafCollectionFactory
     * @param ReplAttributeValueCollectionFactory $replAttributeValueCollectionFactory
     * @param ReplExtendedVariantValueCollectionFactory $replExtendedVariantValueCollectionFactory
     * @param \Magento\Catalog\Model\ResourceModel\Product $productResourceModel
     * @param StockRegistryInterface $stockRegistry
     * @param CategoryRepositoryInterface $categoryRepository
     * @param CategoryLinkRepositoryInterface $categoryLinkRepositoryInterface
     * @param CollectionFactory $collectionFactory
     * @param ReplImageLinkCollectionFactory $replImageLinkCollectionFactory
     * @param Processor $imageProcessor
     * @param MediaGalleryProcessor $mediaGalleryProcessor
     * @param UpdateHandler $updateHandler
     * @param EntryConverterPool $entryConverterPool
     * @param Factory $optionsFactory
     * @param AttributeSetRepositoryInterface $attributeSetRepository
     * @param TypeFactory $eavTypeFactory
     * @param SetFactory $attributeSetFactory
     * @param AttributeSetManagement $attributeSetManagement
     * @param AttributeManagement $attributeManagement
     * @param GroupFactory $attributeSetGroupFactory
     * @param AttributeGroupRepositoryInterface $attributeGroupRepository
     * @param ReplItemUnitOfMeasureSearchResultsFactory $replItemUnitOfMeasureSearchResultsFactory
     * @param EavAttributeCollectionFactory $eavAttributeCollectionFactory
     * @param ReplItemVendorCollectionFactory $replItemVendorCollectionFactory
     */
    public function __construct(
        Factory $factory,
        Item $item,
        Config $eavConfig,
        Configurable $configurable,
        Attribute $attribute,
        ProductInterfaceFactory $productInterfaceFactory,
        ProductRepositoryInterface $productRepository,
        ProductAttributeMediaGalleryEntryInterface $attributeMediaGalleryEntry,
        ImageContentFactory $imageContent,
        CollectionFactory $categoryCollectionFactory,
        CategoryLinkManagementInterface $categoryLinkManagement,
        ReplItemRepository $itemRepository,
        ReplItemVariantRegistrationRepository $replItemVariantRegistrationRepository,
        ReplExtendedVariantValueRepository $extendedVariantValueRepository,
        ReplImageRepository $replImageRepository,
        ReplHierarchyLeafRepository $replHierarchyLeafRepository,
        ReplBarcodeRepository $replBarcodeRepository,
        ReplPriceRepository $replPriceRepository,
        ReplItemUnitOfMeasure $replItemUnitOfMeasureRepository,
        ReplInvStatusRepository $replInvStatusRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrder $sortOrder,
        FilterBuilder $filterBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        ReplImageLinkRepositoryInterface $replImageLinkRepositoryInterface,
        LoyaltyHelper $loyaltyHelper,
        ReplicationHelper $replicationHelper,
        ReplAttributeValueRepositoryInterface $replAttributeValueRepositoryInterface,
        ReplLoyVendorItemMappingRepositoryInterface $replVendorItemMappingRepositoryInterface,
        Logger $logger,
        LSR $LSR,
        ConfigurableProTypeModel $configurableProTypeModel,
        StockHelper $stockHelper,
        ReplInvStatusCollectionFactory $replInvStatusCollectionFactory,
        ReplPriceCollectionFactory $replPriceCollectionFactory,
        ReplItemUomCollectionFactory $replItemUomCollectionFactory,
        ReplHierarchyLeafCollectionFactory $replHierarchyLeafCollectionFactory,
        ReplAttributeValueCollectionFactory $replAttributeValueCollectionFactory,
        ReplExtendedVariantValueCollectionFactory $replExtendedVariantValueCollectionFactory,
        \Magento\Catalog\Model\ResourceModel\Product $productResourceModel,
        StockRegistryInterface $stockRegistry,
        CategoryRepositoryInterface $categoryRepository,
        CategoryLinkRepositoryInterface $categoryLinkRepositoryInterface,
        CollectionFactory $collectionFactory,
        ReplImageLinkCollectionFactory $replImageLinkCollectionFactory,
        Processor $imageProcessor,
        MediaGalleryProcessor $mediaGalleryProcessor,
        UpdateHandler $updateHandler,
        EntryConverterPool $entryConverterPool,
        Factory $optionsFactory,
        AttributeSetRepositoryInterface $attributeSetRepository,
        TypeFactory $eavTypeFactory,
        SetFactory $attributeSetFactory,
        AttributeSetManagement $attributeSetManagement,
        AttributeManagement $attributeManagement,
        GroupFactory $attributeSetGroupFactory,
        AttributeGroupRepositoryInterface $attributeGroupRepository,
        ReplItemUnitOfMeasureSearchResultsFactory $replItemUnitOfMeasureSearchResultsFactory,
        EavAttributeCollectionFactory $eavAttributeCollectionFactory,
        ReplItemVendorCollectionFactory $replItemVendorCollectionFactory
    ) {
        $this->factory                                   = $factory;
        $this->item                                      = $item;
        $this->eavConfig                                 = $eavConfig;
        $this->configurable                              = $configurable;
        $this->attribute                                 = $attribute;
        $this->productFactory                            = $productInterfaceFactory;
        $this->productRepository                         = $productRepository;
        $this->attributeMediaGalleryEntry                = $attributeMediaGalleryEntry;
        $this->imageContent                              = $imageContent;
        $this->categoryCollectionFactory                 = $categoryCollectionFactory;
        $this->categoryLinkManagement                    = $categoryLinkManagement;
        $this->itemRepository                            = $itemRepository;
        $this->replItemVariantRegistrationRepository     = $replItemVariantRegistrationRepository;
        $this->extendedVariantValueRepository            = $extendedVariantValueRepository;
        $this->imageRepository                           = $replImageRepository;
        $this->replHierarchyLeafRepository               = $replHierarchyLeafRepository;
        $this->replBarcodeRepository                     = $replBarcodeRepository;
        $this->replPriceRepository                       = $replPriceRepository;
        $this->replItemUomRepository                     = $replItemUnitOfMeasureRepository;
        $this->replInvStatusRepository                   = $replInvStatusRepository;
        $this->searchCriteriaBuilder                     = $searchCriteriaBuilder;
        $this->sortOrder                                 = $sortOrder;
        $this->filterBuilder                             = $filterBuilder;
        $this->filterGroupBuilder                        = $filterGroupBuilder;
        $this->logger                                    = $logger;
        $this->replImageLinkRepositoryInterface          = $replImageLinkRepositoryInterface;
        $this->loyaltyHelper                             = $loyaltyHelper;
        $this->replicationHelper                         = $replicationHelper;
        $this->replAttributeValueRepositoryInterface     = $replAttributeValueRepositoryInterface;
        $this->replVendorItemMappingRepositoryInterface  = $replVendorItemMappingRepositoryInterface;
        $this->lsr                                       = $LSR;
        $this->configurableProTypeModel                  = $configurableProTypeModel;
        $this->stockHelper                               = $stockHelper;
        $this->replInvStatusCollectionFactory            = $replInvStatusCollectionFactory;
        $this->replPriceCollectionFactory                = $replPriceCollectionFactory;
        $this->replItemUomCollectionFactory              = $replItemUomCollectionFactory;
        $this->replHierarchyLeafCollectionFactory        = $replHierarchyLeafCollectionFactory;
        $this->replAttributeValueCollectionFactory       = $replAttributeValueCollectionFactory;
        $this->productResourceModel                      = $productResourceModel;
        $this->stockRegistry                             = $stockRegistry;
        $this->categoryLinkRepositoryInterface           = $categoryLinkRepositoryInterface;
        $this->collectionFactory                         = $collectionFactory;
        $this->categoryRepository                        = $categoryRepository;
        $this->replImageLinkCollectionFactory            = $replImageLinkCollectionFactory;
        $this->imageProcessor                            = $imageProcessor;
        $this->mediaGalleryProcessor                     = $mediaGalleryProcessor;
        $this->updateHandler                             = $updateHandler;
        $this->entryConverterPool                        = $entryConverterPool;
        $this->attributeSetRepository                    = $attributeSetRepository;
        $this->optionsFactory                            = $optionsFactory;
        $this->replExtendedVariantValueCollectionFactory = $replExtendedVariantValueCollectionFactory;
        $this->eavTypeFactory                            = $eavTypeFactory;
        $this->attributeSetFactory                       = $attributeSetFactory;
        $this->attributeSetManagement                    = $attributeSetManagement;
        $this->attributeManagement                       = $attributeManagement;
        $this->attributeSetGroupFactory                  = $attributeSetGroupFactory;
        $this->attributeGroupRepository                  = $attributeGroupRepository;
        $this->replItemUnitOfMeasureSearchResultsFactory = $replItemUnitOfMeasureSearchResultsFactory;
        $this->eavAttributeCollectionFactory             = $eavAttributeCollectionFactory;
        $this->replItemVendorCollectionFactory           = $replItemVendorCollectionFactory;
    }

    /**
     * @param null $storeData
     * @throws InputException
     * @throws LocalizedException
     * @throws StateException
     */
    public function execute($storeData = null)
    {
        if (!empty($storeData) && $storeData instanceof StoreInterface) {
            $stores = [$storeData];
        } else {
            $stores = $this->lsr->getAllStores();
        }

        if (!empty($stores)) {
            foreach ($stores as $store) {
                $this->lsr->setStoreId($store->getId());
                $this->store = $store;
                if ($this->lsr->isLSR($this->store->getId())) {
                    $this->replicationHelper->updateConfigValue(
                        $this->replicationHelper->getDateTime(),
                        LSR::SC_CRON_PRODUCT_CONFIG_PATH_LAST_EXECUTE,
                        $store->getId()
                    );
                    $fullReplicationImageLinkStatus = $this->lsr->getStoreConfig(
                        ReplEcommImageLinksTask::CONFIG_PATH_STATUS,
                        $store->getId()
                    );
                    $fullReplicationBarcodeStatus   = $this->lsr->getStoreConfig(
                        ReplEcommBarcodesTask::CONFIG_PATH_STATUS,
                        $store->getId()
                    );
                    $fullReplicationPriceStatus     = $this->lsr->getStoreConfig(
                        ReplEcommPricesTask::CONFIG_PATH_STATUS,
                        $store->getId()
                    );
                    $fullReplicationInvStatus       = $this->lsr->getStoreConfig(
                        ReplEcommInventoryStatusTask::CONFIG_PATH_STATUS,
                        $store->getId()
                    );
                    $cronCategoryCheck              = $this->lsr->getStoreConfig(
                        LSR::SC_SUCCESS_CRON_CATEGORY,
                        $store->getId()
                    );
                    $cronAttributeCheck             = $this->lsr->getStoreConfig(
                        LSR::SC_SUCCESS_CRON_ATTRIBUTE,
                        $store->getId()
                    );
                    $cronAttributeVariantCheck      = $this->lsr->getStoreConfig(
                        LSR::SC_SUCCESS_CRON_ATTRIBUTE_VARIANT,
                        $store->getId()
                    );
                    if ($cronCategoryCheck == 1 &&
                        $cronAttributeCheck == 1 &&
                        $cronAttributeVariantCheck == 1 &&
                        $fullReplicationImageLinkStatus == 1 &&
                        $fullReplicationBarcodeStatus == 1 &&
                        $fullReplicationPriceStatus == 1 &&
                        $fullReplicationInvStatus == 1) {
                        $this->logger->debug('Running ProductCreateTask for Store ' . $store->getName());
                        $val1 = ini_get('max_execution_time');
                        $val2 = ini_get('memory_limit');
                        $this->logger->debug('ENV Variables Values before:' . $val1 . ' ' . $val2);
                        // @codingStandardsIgnoreStart
                        @ini_set('max_execution_time', 3600);
                        @ini_set('memory_limit', -1);
                        // @codingStandardsIgnoreEnd
                        $val1 = ini_get('max_execution_time');
                        $val2 = ini_get('memory_limit');
                        $this->logger->debug('ENV Variables Values after:' . $val1 . ' ' . $val2);
                        $this->webStoreId = $this->lsr->getStoreConfig(
                            LSR::SC_SERVICE_STORE,
                            $store->getId()
                        );
                        $storeId          = $this->lsr->getStoreConfig(LSR::SC_SERVICE_STORE, $store->getId());
                        $productBatchSize = $this->lsr->getStoreConfig(
                            LSR::SC_REPLICATION_PRODUCT_BATCHSIZE,
                            $store->getId()
                        );
                        $criteria         = $this->replicationHelper->buildCriteriaForNewItems(
                            'scope_id',
                            $store->getId(),
                            'eq',
                            $productBatchSize
                        );
                        /** @var ReplItemSearchResults $items */
                        $items = $this->itemRepository->getList($criteria);
                        /** @var ReplItem $item */
                        foreach ($items->getItems() as $item) {
                            try {
                                $productData     = $this->productRepository->get(
                                    $item->getNavId(),
                                    false,
                                    $store->getId()
                                );
                                $websitesProduct = $productData->getWebsiteIds();
                                /** Check if item exist in the website and assign it if it doesn't exist*/
                                if (!in_array($store->getWebsiteId(), $websitesProduct, true)) {
                                    $websitesProduct[] = $store->getWebsiteId();
                                    $productData->setWebsiteIds($websitesProduct);
                                }
                                $productData->setName($item->getDescription());
                                $productData->setMetaTitle($item->getDescription());
                                $productData->setDescription($item->getDetails());
                                $productData->setWeight($item->getGrossWeight());
                                $productData->setAttributeSetId($productData->getAttributeSetId());
                                $productData->setCustomAttribute('uom', $item->getBaseUnitOfMeasure());
                                $productData = $this->setProductStatus($productData, $item->getBlockedOnECom());
                                $product     = $this->getProductAttributes($productData, $item);
                                try {
                                    // @codingStandardsIgnoreLine
                                    $productSaved = $this->productRepository->save($product);
                                    $this->updateProductStatusGlobal($productSaved);
                                } catch (Exception $e) {
                                    $this->logger->debug($e->getMessage());
                                    $item->setData('is_failed', 1);
                                }
                                $item->setData('is_updated', 0);
                                $item->setData('processed_at', $this->replicationHelper->getDateTime());
                                $item->setData('processed', 1);
                                $this->itemRepository->save($item);
                            } catch (NoSuchEntityException $e) {
                                /** @var Product $product */
                                $product = $this->productFactory->create();
                                $product->setStoreId($store->getId());
                                $product->setWebsiteIds([$store->getWebsiteId()]);
                                $product->setName($item->getDescription());
                                $product->setMetaTitle($item->getDescription());
                                $product->setSku($item->getNavId());
                                $product->setUrlKey(
                                    $this->replicationHelper->oSlug($item->getDescription() . '-' . $item->getNavId())
                                );
                                $product->setVisibility(Visibility::VISIBILITY_BOTH);
                                $product->setWeight($item->getGrossWeight());
                                $product->setDescription($item->getDetails());
                                $itemPrice = $this->getItemPrice($item->getNavId());
                                if (isset($itemPrice)) {
                                    $product->setPrice($itemPrice->getUnitPrice());
                                } else {
                                    $product->setPrice($item->getUnitPrice());
                                }
                                $attributeSetId = $this->getAttributeSetId($item);
                                $product->setAttributeSetId($attributeSetId);
                                $product = $this->setProductStatus($product, $item->getBlockedOnECom());
                                $product->setTypeId(Type::TYPE_SIMPLE);
                                $product->setCustomAttribute('uom', $item->getBaseUnitOfMeasure());
                                /** @var ReplBarcodeRepository $itemBarcodes */
                                $itemBarcodes = $this->_getBarcode($item->getNavId());
                                if (isset($itemBarcodes[$item->getNavId()])) {
                                    $product->setCustomAttribute('barcode', $itemBarcodes[$item->getNavId()]);
                                }
                                $itemStock = $this->getInventoryStatus($item->getNavId(), $storeId);
                                $product->setStockData([
                                    'use_config_manage_stock' => 1,
                                    'is_in_stock'             => ($itemStock > 0) ? 1 : 0,
                                    'qty'                     => $itemStock
                                ]);
                                $product = $this->getProductAttributes($product, $item);
                                try {
                                    // @codingStandardsIgnoreLine
                                    $this->logger->debug('Trying to save product ' . $item->getNavId() . ' in store ' . $store->getName());
                                    /** @var ProductRepositoryInterface $productSaved */
                                    $productSaved = $this->productRepository->save($product);
                                    // @codingStandardsIgnoreLine
                                    $variants             = $this->getNewOrUpdatedProductVariants(-1, $item->getNavId());
                                    $uomCodesNotProcessed = $this->getNewOrUpdatedProductUoms(-1, $item->getNavId());
                                    $totalUomCodes        = $this->getUomCodes($item->getNavId());
                                    if (!empty($variants) || count($totalUomCodes[$item->getNavId()]) > 1) {
                                        $this->createConfigurableProducts(
                                            $productSaved,
                                            $item,
                                            $itemBarcodes,
                                            $variants,
                                            $totalUomCodes,
                                            $uomCodesNotProcessed
                                        );
                                    }
                                    $this->replicationHelper->assignProductToCategories($productSaved, $this->store);
                                } catch (Exception $e) {
                                    $this->logger->debug($e->getMessage());
                                    $item->setData('is_failed', 1);
                                }
                                $item->setData('processed_at', $this->replicationHelper->getDateTime());
                                $item->setData('processed', 1);
                                $item->setData('is_updated', 0);
                                $this->itemRepository->save($item);
                            }
                        }
                        if ($items->getTotalCount() == 0) {
                            $this->caterItemsRemoval();
                            $fullReplicationVariantStatus = $this->lsr->getStoreConfig(
                                ReplEcommItemVariantRegistrationsTask::CONFIG_PATH_STATUS,
                                $store->getId()
                            );
                            if ($fullReplicationVariantStatus == 1) {
                                $this->updateVariantsOnly();
                                $this->caterVariantsRemoval();
                                $this->caterUomsRemoval();
                            }
                            $this->updateBarcodeOnly();
                        }
                        if ($this->getRemainingRecords($store) == 0) {
                            $this->cronStatus = true;
                        }
                        $this->logger->debug('End ProductCreateTask for Store ' . $store->getName());
                    } else {
                        // @codingStandardsIgnoreLine
                        $this->logger->debug('Product Replication cron fails because dependent crons were not executed successfully for Store ' . $store->getName() .
                            "\n Status cron CategoryCheck = " . $cronCategoryCheck .
                            "\n Status cron AttributeCheck = " . $cronAttributeCheck .
                            "\n Status cron AttributeVariantCheck = " . $cronAttributeVariantCheck .
                            "\n Status full ReplicationImageLinkStatus = " . $fullReplicationImageLinkStatus .
                            "\n Status full ReplicationBarcodeStatus = " . $fullReplicationBarcodeStatus .
                            "\n Status full ReplicationPriceStatus = " . $fullReplicationPriceStatus .
                            "\n Status full ReplicationInvStatus = " . $fullReplicationInvStatus);
                    }
                    // @codingStandardsIgnoreLine
                    $this->replicationHelper->updateCronStatus($this->cronStatus, LSR::SC_SUCCESS_CRON_PRODUCT, $store->getId());
                }
                $this->lsr->setStoreId(null);
            }
        }
    }

    /**
     * @param null $storeData
     * @return array
     * @throws InputException
     * @throws LocalizedException
     * @throws StateException
     */
    public function executeManually($storeData = null)
    {
        $this->execute($storeData);
        $itemsLeftToProcess = (int)$this->getRemainingRecords($storeData);
        return [$itemsLeftToProcess];
    }

    /**
     * @param ProductInterface $product
     * @param ReplItem $replItem
     * @return ProductInterface
     * @throws LocalizedException
     */
    public function getProductAttributes(
        ProductInterface $product,
        ReplItem $replItem
    ) {
        $criteria = $this->replicationHelper->buildCriteriaForProductAttributes(
            $replItem->getNavId(),
            -1,
            true,
            $this->store->getId()
        );
        /** @var ReplAttributeValueSearchResults $items */
        $items = $this->replAttributeValueRepositoryInterface->getList($criteria);
        /** @var ReplAttributeValue $item */
        foreach ($items->getItems() as $item) {
            $formattedCode = $this->replicationHelper->formatAttributeCode($item->getCode());
            $attribute     = $this->eavConfig->getAttribute('catalog_product', $formattedCode);
            if ($attribute->getFrontendInput() == 'multiselect') {
                $value = $this->_getOptionIDByCode($formattedCode, $item->getValue());
            } elseif ($attribute->getFrontendInput() == 'boolean') {
                if (strtolower($item->getValue()) == 'yes') {
                    $value = 1;
                } else {
                    $value = 0;
                }
            } else {
                $value = $item->getValue();
            }
            $product->setData($formattedCode, $value);
            $item->setData('processed_at', $this->replicationHelper->getDateTime());
            $item->setData('processed', 1);
            $item->setData('is_updated', 0);
            // @codingStandardsIgnoreLine
            $this->replAttributeValueRepositoryInterface->save($item);
        }
        return $product;
    }

    /**
     * @param $productImages
     * @return array
     * @throws Exception
     */
    public function getMediaGalleryEntries($productImages)
    {
        $galleryArray = [];
        /** @var ReplImageLink $image */
        $i = 0;
        foreach ($productImages as $image) {
            if ($image->getIsDeleted() == 1) {
                $image->setData('processed_at', $this->replicationHelper->getDateTime());
                $image->setData('processed', 1);
                $image->setData('is_updated', 0);
                // @codingStandardsIgnoreLine
                $this->replImageLinkRepositoryInterface->save($image);
                continue;
            }
            $types           = [];
            $imageSize       = [
                'height' => LSR::DEFAULT_ITEM_IMAGE_HEIGHT,
                'width'  => LSR::DEFAULT_ITEM_IMAGE_WIDTH
            ];
            $imageSizeObject = $this->loyaltyHelper->getImageSize($imageSize);
            $result          = $this->loyaltyHelper->getImageById($image->getImageId(), $imageSizeObject);
            if (!empty($result) && !empty($result['format']) && !empty($result['image'])) {
                $mimeType = $this->getMimeType($result['image']);
                if ($this->replicationHelper->isMimeTypeValid($mimeType)) {
                    $imageContent = $this->imageContent->create()
                        ->setBase64EncodedData($result['image'])
                        ->setName($this->replicationHelper->oSlug($image->getImageId()))
                        ->setType($mimeType);
                    $this->attributeMediaGalleryEntry->setMediaType('image')
                        ->setLabel(($image->getDescription()) ?: __('Product Image'))
                        ->setPosition($image->getDisplayOrder())
                        ->setDisabled(false)
                        ->setContent($imageContent);
                    if ($i == 0) {
                        $types = ['image', 'small_image', 'thumbnail'];
                    }
                    $this->attributeMediaGalleryEntry->setTypes($types);
                    $galleryArray[] = clone $this->attributeMediaGalleryEntry;
                    $i++;
                } else {
                    $image->setData('is_failed', 1);
                    $this->logger->debug('MIME Type is not valid for Image Id : ' . $image->getImageId());
                }
            } else {
                $image->setData('is_failed', 1);
                $this->logger->debug('Response is empty or format empty for Image Id : ' . $image->getImageId());
            }
            $image->setData('processed_at', $this->replicationHelper->getDateTime());
            $image->setData('processed', 1);
            $image->setData('is_updated', 0);
            // @codingStandardsIgnoreLine
            $this->replImageLinkRepositoryInterface->save($image);
        }
        return $galleryArray;
    }

    /**
     * @param $image64
     * @return string
     */
    private function getMimeType($image64)
    {
        // @codingStandardsIgnoreLine
        return finfo_buffer(finfo_open(), base64_decode($image64), FILEINFO_MIME_TYPE);
    }

    /**
     * @param int $pageSize
     * @param null $itemId
     * @return mixed
     */
    private function getNewOrUpdatedProductVariants($pageSize = 100, $itemId = null)
    {
        $filters = [
            ['field' => 'VariantId', 'value' => true, 'condition_type' => 'notnull'],
            ['field' => 'scope_id', 'value' => $this->store->getId(), 'condition_type' => 'eq'],
        ];
        if (isset($itemId)) {
            $filters[] = ['field' => 'ItemId', 'value' => $itemId, 'condition_type' => 'eq'];
        } else {
            $filters[] = ['field' => 'ItemId', 'value' => true, 'condition_type' => 'notnull'];
        }
        $criteria = $this->replicationHelper->buildCriteriaForArray($filters, $pageSize);
        return $this->replItemVariantRegistrationRepository->getList($criteria)->getItems();
    }

    /**
     * @param null $itemId
     * @return mixed
     */
    public function getProductVariants($itemId = null)
    {
        $filters = [
            ['field' => 'VariantId', 'value' => true, 'condition_type' => 'notnull'],
            ['field' => 'scope_id', 'value' => $this->store->getId(), 'condition_type' => 'eq'],
        ];
        if (isset($itemId)) {
            $filters[] = ['field' => 'ItemId', 'value' => $itemId, 'condition_type' => 'eq'];
        } else {
            $filters[] = ['field' => 'ItemId', 'value' => true, 'condition_type' => 'notnull'];
        }
        $criteria = $this->replicationHelper->buildCriteriaForDirect($filters, -1);
        return $this->replItemVariantRegistrationRepository->getList($criteria)->getItems();
    }

    /**
     * @param int $pageSize
     * @param null $itemId
     * @return mixed
     */
    public function getNewOrUpdatedProductUoms($pageSize = 100, $itemId = null)
    {
        $filters = [
            ['field' => 'Code', 'value' => true, 'condition_type' => 'notnull'],
            ['field' => 'scope_id', 'value' => $this->store->getId(), 'condition_type' => 'eq'],
        ];
        if (isset($itemId)) {
            $filters[] = ['field' => 'ItemId', 'value' => $itemId, 'condition_type' => 'eq'];
        } else {
            $filters[] = ['field' => 'ItemId', 'value' => true, 'condition_type' => 'notnull'];
        }
        $collection    = $this->replItemUomCollectionFactory->create();
        $criteria      = $this->replicationHelper->buildCriteriaForArray($filters, $pageSize);
        $resultFactory = $this->replItemUnitOfMeasureSearchResultsFactory->create();
        return $this->replicationHelper->setCollection($collection, $criteria, $resultFactory, "Order");
    }

    /**
     * Return all updated variants only
     * @param type $filters
     * @return type
     */
    private function getDeletedItemsOnly($filters)
    {
        $criteria = $this->replicationHelper->buildCriteriaGetDeletedOnly($filters);
        return $this->itemRepository->getList($criteria);
    }

    /**
     * Return all updated variants only
     * @param array $filters
     * @return type
     */
    private function getDeletedVariantsOnly($filters)
    {
        $criteria = $this->replicationHelper->buildCriteriaGetDeletedOnly($filters);
        return $this->replItemVariantRegistrationRepository->getList($criteria)->getItems();
    }

    /**
     * Return all updated variants only
     * @param array $filters
     * @return type
     */
    private function getDeletedUomsOnly($filters)
    {
        $criteria = $this->replicationHelper->buildCriteriaGetDeletedOnly($filters);
        return $this->replItemUomRepository->getList($criteria)->getItems();
    }

    /**
     * @param $code
     * @param $value
     * @return null|string
     * @throws LocalizedException
     */
    public function _getOptionIDByCode($code, $value)
    {
        $attribute = $this->eavConfig->getAttribute('catalog_product', $code);
        return $attribute->getSource()->getOptionId($value);
    }

    /**
     * @param $itemId
     * @return array
     */
    public function _getAttributesCodes($itemId)
    {
        $finalCodes = [];
        try {
            $searchCriteria = $this->searchCriteriaBuilder->addFilter('ItemId', $itemId)
                ->addFilter('scope_id', $this->store->getId(), 'eq')->create();
            $sortOrder      = $this->sortOrder->setField('DimensionLogicalOrder')->setDirection(SortOrder::SORT_ASC);
            $searchCriteria->setSortOrders([$sortOrder]);
            $attributeCodes = $this->extendedVariantValueRepository->getList($searchCriteria)->getItems();
            /** @var ReplExtendedVariantValue $valueCode */
            foreach ($attributeCodes as $valueCode) {
                $formattedCode                           = $this->replicationHelper->formatAttributeCode($valueCode->getCode());
                $finalCodes[$valueCode->getDimensions()] = $formattedCode;
                $valueCode->setData('processed_at', $this->replicationHelper->getDateTime());
                $valueCode->setData('processed', 1);
                $valueCode->setData('is_updated', 0);
                // @codingStandardsIgnoreLine
                $this->extendedVariantValueRepository->save($valueCode);
            }
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
        return $finalCodes;
    }

    /**
     * Return all the barcodes including the variant
     *
     * @param $itemId
     * @return array
     */
    public function _getBarcode($itemId)
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter('ItemId', $itemId)
            ->addFilter('scope_id', $this->store->getId(), 'eq')->create();
        $allBarCodes    = [];
        /** @var ReplBarcodeRepository $itemBarcodes */
        $itemBarcodes = $this->replBarcodeRepository->getList($searchCriteria)->getItems();
        foreach ($itemBarcodes as $itemBarcode) {
            $sku = $itemBarcode->getItemId() .
                (($itemBarcode->getVariantId()) ? '-' . $itemBarcode->getVariantId() : '');

            if (!empty($itemBarcode->getUnitOfMeasure())) {
                $baseUnitOfMeasure = $this->replicationHelper->getBaseUnitOfMeasure($itemBarcode->getItemId());
                if ($itemBarcode->getUnitOfMeasure() != $baseUnitOfMeasure) {
                    $sku = $sku . '-' . $itemBarcode->getUnitOfMeasure();
                }
            }

            $allBarCodes[$sku] = $itemBarcode->getNavId();
        }
        return $allBarCodes;
    }

    /**
     * Return item
     *
     * @param $itemId
     * @return array
     */
    public function _getItem($itemId)
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter('nav_id', $itemId)->addFilter(
            'scope_id',
            $this->store->getId(),
            'eq'
        )->create();
        /** @var ReplItemRepository $items */
        $items = $this->itemRepository->getList($searchCriteria)->getItems();
        foreach ($items as $item) {
            return $item;
        }
    }

    /**
     * @param $itemId
     * @param null $variantId
     * @param null $unitOfMeasure
     * @return mixed
     */
    public function getItemPrice($itemId, $variantId = null, $unitOfMeasure = null)
    {
        $parameter  = null;
        $parameter2 = null;

        $filters = [
            ['field' => 'ItemId', 'value' => $itemId, 'condition_type' => 'eq'],
            ['field' => 'StoreId', 'value' => $this->webStoreId, 'condition_type' => 'eq'],
            ['field' => 'scope_id', 'value' => $this->store->getId(), 'condition_type' => 'eq'],
        ];

        if (!$unitOfMeasure) {
            $filters[] = ['field' => 'QtyPerUnitOfMeasure', 'value' => 0, 'condition_type' => 'eq'];
        }

        if ($variantId) {
            $parameter = ['field' => 'VariantId', 'value' => $variantId, 'condition_type' => 'eq'];
        }

        if ($unitOfMeasure) {
            $parameter = ['field' => 'UnitOfMeasure', 'value' => $unitOfMeasure, 'condition_type' => 'eq'];
        }

        if (isset($unitOfMeasure) && isset($variantId)) {
            $parameter  = ['field' => 'UnitOfMeasure', 'value' => $unitOfMeasure, 'condition_type' => 'eq'];
            $parameter2 = ['field' => 'VariantId', 'value' => $variantId, 'condition_type' => 'eq'];
        }

        $item           = null;
        $searchCriteria = $this->replicationHelper->buildCriteriaForDirect($filters, 1, 1, $parameter, $parameter2);
        /** @var ReplPriceRepository $items */
        try {
            $items = $this->replPriceRepository->getList($searchCriteria)->getItems();
            if (!empty($items)) {
                $item = reset($items);
                /** @var ReplInvStatus $invStatus */
                $item->setData('is_updated', 0);
                $item->setData('processed', 1);
                $item->setData('processed_at', $this->replicationHelper->getDateTime());
                $this->replPriceRepository->save($item);
            }
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
        return $item;
    }

    /**
     * @param $itemId
     * @return array
     */
    public function getUomCodes($itemId)
    {
        $filters = [
            ['field' => 'ItemId', 'value' => $itemId, 'condition_type' => 'eq'],
            ['field' => 'scope_id', 'value' => $this->store->getId(), 'condition_type' => 'eq'],
        ];

        $itemUom          = [];
        $itemUom[$itemId] = [];
        $searchCriteria   = $this->replicationHelper->buildCriteriaForDirect($filters, -1);
        /** @var ReplItemUnitOfMeasure $items */
        try {
            $items = $this->replItemUomRepository->getList($searchCriteria)->getItems();
            foreach ($items as $item) {
                /** @var \Ls\Replication\Model\ReplItemUnitOfMeasure $item */
                $itemUom[$itemId][$item->getDescription()] = $item->getCode();
            }
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
        return $itemUom;
    }

    /**
     * @param $itemId
     * @return array
     */
    public function getUomCodesProcessed($itemId)
    {
        $filters = [
            ['field' => 'main_table.ItemId', 'value' => $itemId, 'condition_type' => 'eq'],
            ['field' => 'main_table.scope_id', 'value' => $this->store->getId(), 'condition_type' => 'eq'],
            ['field' => 'main_table.processed', 'value' => 1, 'condition_type' => 'eq'],
            ['field' => 'main_table.is_updated', 'value' => 0, 'condition_type' => 'eq'],
        ];

        $itemUom = [];
        /** @var  $collection */
        $collection = $this->replItemUomCollectionFactory->create();
        $criteria   = $this->replicationHelper->buildCriteriaForDirect($filters, -1);

        /** we only need unique product Id's which has any images to modify */
        $this->replicationHelper->setCollectionPropertiesPlusJoin(
            $collection,
            $criteria,
            'ItemId',
            'ls_replication_repl_item',
            'nav_id',
            false,
            false
        );

        $collection->getSelect()->columns('second.BaseUnitOfMeasure');

        /** @var ReplItemUnitOfMeasure $items */
        try {
            if ($collection->getSize() > 0) {
                foreach ($collection->getItems() as $item) {
                    /** @var \Ls\Replication\Model\ReplItemUnitOfMeasure $item */
                    $itemUom[$itemId][$item->getDescription()]    = $item->getCode();
                    $itemUom[$itemId . '-' . 'BaseUnitOfMeasure'] = $item->getData('BaseUnitOfMeasure');
                }
            }
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
        return $itemUom;
    }

    /**
     * Update/Add the modified/added variants of the item
     */
    public function updateVariantsOnly()
    {
        $batchSize          = $this->replicationHelper->getVariantBatchSize();
        $allUpdatedVariants = $this->getNewOrUpdatedProductVariants($batchSize);
        $uomCodes           = $this->getNewOrUpdatedProductUoms($batchSize);
        $items              = [];
        if (!empty($allUpdatedVariants)) {
            foreach ($allUpdatedVariants as $variant) {
                $items[] = $variant->getItemId();
            }
        }
        if (!empty($uomCodes)) {
            foreach ($uomCodes as $uomCode) {
                $items[] = $uomCode->getItemId();
            }
        }
        $items = array_unique($items);
        foreach ($items as $item) {
            try {
                $productData = $this->productRepository->get($item, true, $this->store->getId());
                /** @var ReplBarcodeRepository $itemBarcodes */
                $itemBarcodes = $this->_getBarcode($item);
                /** @var ReplItemRepository $itemData */
                $itemData             = $this->_getItem($item);
                $productVariants      = $this->getNewOrUpdatedProductVariants(-1, $item);
                $uomCodesNotProcessed = $this->getNewOrUpdatedProductUoms(-1, $item);
                $totalUomCodes        = $this->getUomCodes($itemData->getNavId());
                if (count($totalUomCodes[$itemData->getNavId()]) > 1) {
                    $productVariants = $this->getProductVariants($itemData->getNavId());
                }
                if (!empty($productVariants) || count($totalUomCodes[$itemData->getNavId()]) > 1) {
                    $this->createConfigurableProducts(
                        $productData,
                        $itemData,
                        $itemBarcodes,
                        $productVariants,
                        $totalUomCodes,
                        $uomCodesNotProcessed
                    );
                }
            } catch (Exception $e) {
                $this->logger->debug('Problem with sku: ' . $item . ' in ' . __METHOD__);
                $this->logger->debug($e->getMessage());
            }
        }
    }

    /**
     * Cater Configurable Products Removal
     */
    public function caterItemsRemoval()
    {
        $filters = [
            ['field' => 'nav_id', 'value' => true, 'condition_type' => 'notnull'],
            ['field' => 'scope_id', 'value' => $this->store->getId(), 'condition_type' => 'eq']
        ];
        $items   = $this->getDeletedItemsOnly($filters);
        if (!empty($items->getItems())) {
            foreach ($items->getItems() as $value) {
                $sku         = $value->getNavId();
                $productData = $this->productRepository->get($sku, true, $this->store->getId());
                $productData = $this->setProductStatus($productData, 1);
                try {
                    $this->productRepository->save($productData);
                } catch (Exception $e) {
                    $this->logger->debug('Problem with sku: ' . $sku . ' in ' . __METHOD__);
                    $this->logger->debug($e->getMessage());
                    $value->setData('is_failed', 1);
                }
                $value->setData('is_updated', 0);
                $value->setData('processed_at', $this->replicationHelper->getDateTime());
                $value->setData('processed', 1);
                // @codingStandardsIgnoreLine
                $this->itemRepository->save($value);
            }
        }
    }

    /**
     * Cater SimpleProducts Removal
     */
    public function caterVariantsRemoval()
    {
        $filters  = [
            ['field' => 'ItemId', 'value' => true, 'condition_type' => 'notnull'],
            ['field' => 'scope_id', 'value' => $this->store->getId(), 'condition_type' => 'eq'],

        ];
        $variants = $this->getDeletedVariantsOnly($filters);

        if (!empty($variants)) {
            /** @var ReplItemVariantRegistration $value */
            foreach ($variants as $value) {
                $d1     = (($value->getVariantDimension1()) ?: '');
                $d2     = (($value->getVariantDimension2()) ?: '');
                $d3     = (($value->getVariantDimension3()) ?: '');
                $d4     = (($value->getVariantDimension4()) ?: '');
                $d5     = (($value->getVariantDimension5()) ?: '');
                $d6     = (($value->getVariantDimension6()) ?: '');
                $itemId = $value->getItemId();
                try {
                    $productData            = $this->productRepository->get($itemId, true, $this->store->getId());
                    $attributeCodes         = $this->_getAttributesCodes($productData->getSku());
                    $configurableAttributes = [];
                    foreach ($attributeCodes as $keyCode => $valueCode) {
                        if (isset($keyCode) && $keyCode != '') {
                            $code                     = $valueCode;
                            $codeValue                = ${'d' . $keyCode};
                            $configurableAttributes[] = ['code' => $code, 'value' => $codeValue];
                        }
                    }
                    $associatedSimpleProduct = $this->getConfAssoProductId($productData, $configurableAttributes);
                    if ($associatedSimpleProduct != null) {
                        $associatedSimpleProduct = $this->setProductStatus($associatedSimpleProduct, 1);
                        // @codingStandardsIgnoreLine
                        $this->productRepository->save($associatedSimpleProduct);
                    }
                } catch (Exception $e) {
                    $this->logger->debug('Problem with sku: ' . $itemId . ' in ' . __METHOD__);
                    $this->logger->debug($e->getMessage());
                    $value->setData('is_failed', 1);
                }
                $value->setData('is_updated', 0);
                $value->setData('processed_at', $this->replicationHelper->getDateTime());
                $value->setData('processed', 1);
                // @codingStandardsIgnoreLine
                $this->replItemVariantRegistrationRepository->save($value);
            }
        }
    }

    /**
     * Cater SimpleProducts Removal for Uoms
     */
    public function caterUomsRemoval()
    {
        $filters = [
            ['field' => 'ItemId', 'value' => true, 'condition_type' => 'notnull'],
            ['field' => 'scope_id', 'value' => $this->store->getId(), 'condition_type' => 'eq'],

        ];
        $uoms    = $this->getDeletedUomsOnly($filters);

        if (!empty($uoms)) {
            /** @var \Ls\Replication\Model\ReplItemUnitOfMeasure $uom */
            foreach ($uoms as $uom) {
                $itemId = $uom->getItemId();
                try {
                    $productData = $this->productRepository->get($itemId, true, $this->store->getId());
                    $children    = $productData->getTypeInstance()->getUsedProducts($productData);
                    foreach ($children as $child) {
                        $childProductData = $this->productRepository->get($child->getSKU());
                        if ($childProductData->getData('uom') == $uom->getCode()) {
                            $childProductData = $this->setProductStatus($childProductData, 1);
                            // @codingStandardsIgnoreLine
                            $this->productRepository->save($childProductData);
                        }
                    }
                } catch (Exception $e) {
                    $this->logger->debug('Problem with sku: ' . $itemId . ' in ' . __METHOD__);
                    $this->logger->debug($e->getMessage());
                    $uom->setData('is_failed', 1);
                }
                $uom->setData('is_updated', 0);
                $uom->setData('IsDeleted', 0);
                $uom->setData('processed_at', $this->replicationHelper->getDateTime());
                $uom->setData('processed', 1);
                // @codingStandardsIgnoreLine
                $this->replItemUomRepository->save($uom);
            }
        }
    }

    /**
     * @param $product
     * @param $nameValueList
     * @return Product|null
     */
    public function getConfAssoProductId($product, $nameValueList)
    {
        //get configurable products attributes array with all values
        // with label (super attribute which use for configuration)
        $assPro = null;
        if ($product->getTypeId() != Configurable::TYPE_CODE) {
            // to bypass situation when simple products are not being properly converted into configurable.
            return $assPro;
        }
        $optionsData      = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);
        $superAttrList    = [];
        $superAttrOptions = [];
        $attributeValues  = [];

        // prepare array with attribute values
        foreach ($optionsData as $option) {
            $superAttrList[]                           = [
                'name' => $option['frontend_label'],
                'code' => $option['attribute_code'],
                'id'   => $option['attribute_id']
            ];
            $superAttrOptions[$option['attribute_id']] = $option['options'];
            foreach ($nameValueList as $nameValue) {
                if ($nameValue['code'] == $option['attribute_code']) {
                    foreach ($option['options'] as $attrOpt) {
                        if ($nameValue['value'] == $attrOpt['label']) {
                            $attributeValues[$option['attribute_id']] = $attrOpt['value'];
                        }
                    }
                }
            }
        }

        if (count($attributeValues) == count($nameValueList)) {
            // pass this prepared array with $product
            $assPro = $this->configurableProTypeModel->getProductByAttributes($attributeValues, $product);
            // it return complete product according to attribute values which you pass
        }
        return $assPro;
    }

    /**
     * Update the modified/added barcode of the items & item variants
     */
    public function updateBarcodeOnly()
    {
        $cronProductCheck = $this->lsr->getStoreConfig(LSR::SC_SUCCESS_CRON_PRODUCT, $this->store->getId());
        $barcodeBatchSize = $this->replicationHelper->getProductBarcodeBatchSize();
        if ($cronProductCheck == 1) {
            $criteria = $this->replicationHelper->buildCriteriaForNewItems(
                'scope_id',
                $this->store->getId(),
                'eq',
                $barcodeBatchSize
            );
            /** @var ReplBarcodeSearchResults $replBarcodes */
            $replBarcodes = $this->replBarcodeRepository->getList($criteria);
            if ($replBarcodes->getTotalCount() > 0) {
                /** @var ReplBarcode $replBarcode */
                foreach ($replBarcodes->getItems() as $replBarcode) {
                    try {
                        if (!$replBarcode->getVariantId()) {
                            $sku = $replBarcode->getItemId();
                        } else {
                            $sku = $replBarcode->getItemId() . '-' . $replBarcode->getVariantId();
                        }
                        if (!empty($replBarcode->getUnitOfMeasure())) {
                            // @codingStandardsIgnoreLine
                            $baseUnitOfMeasure = $this->replicationHelper->getBaseUnitOfMeasure($replBarcode->getItemId());
                            if ($replBarcode->getUnitOfMeasure() != $baseUnitOfMeasure) {
                                $sku = $sku . '-' . $replBarcode->getUnitOfMeasure();
                            }
                        }
                        $productData = $this->productRepository->get($sku, true, $this->store->getId());
                        if (isset($productData)) {
                            $productData->setBarcode($replBarcode->getNavId());
                            // @codingStandardsIgnoreLine
                            $this->productResourceModel->saveAttribute($productData, 'barcode');
                        }
                    } catch (Exception $e) {
                        $this->logger->debug('Problem with sku: ' . $sku . ' in ' . __METHOD__);
                        $this->logger->debug($e->getMessage());
                        $replBarcode->setData('is_failed', 1);
                    }
                    $replBarcode->setData('is_updated', 0);
                    $replBarcode->setData('processed_at', $this->replicationHelper->getDateTime());
                    $replBarcode->setData('processed', 1);
                    $this->replBarcodeRepository->save($replBarcode);
                }
            }
        }
    }

    /**
     * @param $configProduct
     * @param $item
     * @param $itemBarcodes
     * @param $variants
     * @param null $totalUomCodes
     * @param null $uomCodesNotProcessed
     * @throws CouldNotSaveException
     * @throws InputException
     * @throws LocalizedException
     * @throws StateException
     */
    public function createConfigurableProducts(
        $configProduct,
        $item,
        $itemBarcodes,
        $variants,
        $totalUomCodes = null,
        $uomCodesNotProcessed = null
    ) {
        // Get those attribute codes which are assigned to product.
        $attributesCode = $this->_getAttributesCodes($item->getNavId());

        if (!empty($totalUomCodes)) {
            if (count($totalUomCodes[$item->getNavId()]) > 1 && !empty($uomCodesNotProcessed)) {
                $attributesCode [] = LSR::LS_UOM_ATTRIBUTE;
            } else {
                $uomCodesNotProcessed = null;
            }
        }
        $attributesIds        = [];
        $associatedProductIds = [];
        if ($configProduct->getTypeId() == Configurable::TYPE_CODE) {
            $associatedProductIds = $configProduct->getTypeInstance()->getUsedProductIds($configProduct);
        }
        $configurableProductsData = [];
        if (!empty($uomCodesNotProcessed) && !empty($variants)) {
            /** @var \Ls\Replication\Model\ReplItemUnitOfMeasure $uomCode */
            foreach ($uomCodesNotProcessed as $uomCode) {
                /** @var ReplItemVariantRegistration $value */
                foreach ($variants as $value) {
                    if ($uomCode->getCode() != $item->getBaseUnitOfMeasure()) {
                        $sku = $value->getItemId() . '-' . $value->getVariantId() . '-' . $uomCode->getCode();
                    } else {
                        $sku = $value->getItemId() . '-' . $value->getVariantId();
                    }

                    try {
                        $productData = $this->saveProductForWebsite($sku);
                        try {
                            $name                   = $this->getNameForVariant($value, $item);
                            $name                   = $this->getNameForUom($name, $uomCode->getDescription());
                            $associatedProductIds[] = $this->updateConfigProduct($productData, $item, $name, $uomCode);
                            $associatedProductIds   = array_unique($associatedProductIds);
                        } catch (Exception $e) {
                            $this->logger->debug($e->getMessage());
                            $value->setData('is_failed', 1);
                        }
                    } catch (NoSuchEntityException $e) {
                        $isVariantContainNull = $this->validateVariant($attributesCode, $value);
                        if ($isVariantContainNull) {
                            $this->logger->debug('Variant issue : Item ' . $value->getItemId() . '-' . $value->getVariantId() . ' contain null attribute');
                            $value->setData('is_updated', 0);
                            $value->setData('processed_at', $this->replicationHelper->getDateTime());
                            $value->setData('processed', 1);
                            $value->setData('is_failed', 1);
                            $this->replItemVariantRegistrationRepository->save($value);
                            continue;
                        }

                        $name                   = $this->getNameForVariant($value, $item);
                        $name                   = $this->getNameForUom($name, $uomCode->getDescription());
                        $associatedProductIds[] = $this->createConfigProduct(
                            $name,
                            $item,
                            $value,
                            $uomCode,
                            $sku,
                            $configProduct,
                            $attributesCode,
                            $itemBarcodes
                        );
                    }
                    $value->setData('processed_at', $this->replicationHelper->getDateTime());
                    $value->setData('processed', 1);
                    $value->setData('is_updated', 0);
                    $this->replItemVariantRegistrationRepository->save($value);
                }

                $uomCode->setData('processed_at', $this->replicationHelper->getDateTime());
                $uomCode->setData('processed', 1);
                $uomCode->setData('is_updated', 0);
                $this->replItemUomRepository->save($uomCode);
            }
        } elseif (!empty($uomCodesNotProcessed) && empty($variants)) {
            /** @var \Ls\Replication\Model\ReplItemUnitOfMeasure $uomCode */
            foreach ($uomCodesNotProcessed as $uomCode) {
                $value = null;
                $sku   = $uomCode->getItemId() . '-' . $uomCode->getCode();
                $name  = $this->getNameForUom($item->getDescription(), $uomCode->getDescription());
                try {
                    $productData = $this->saveProductForWebsite($sku);
                    try {
                        $associatedProductIds[] = $this->updateConfigProduct($productData, $item, $name, $uomCode);
                        $associatedProductIds   = array_unique($associatedProductIds);
                    } catch (Exception $e) {
                        $this->logger->debug($e->getMessage());
                        $uomCode->setData('is_failed', 1);
                    }
                } catch (NoSuchEntityException $e) {
                    $associatedProductIds[] = $this->createConfigProduct(
                        $name,
                        $item,
                        $value,
                        $uomCode,
                        $sku,
                        $configProduct,
                        $attributesCode,
                        $itemBarcodes
                    );
                }
                $uomCode->setData('processed_at', $this->replicationHelper->getDateTime());
                $uomCode->setData('processed', 1);
                $uomCode->setData('is_updated', 0);
                $this->replItemUomRepository->save($uomCode);
            }
        } else {
            /** @var ReplItemVariantRegistration $value */
            foreach ($variants as $value) {
                $sku     = $value->getItemId() . '-' . $value->getVariantId();
                $uomCode = null;
                try {
                    $productData = $this->saveProductForWebsite($sku);
                    try {
                        $name                   = $this->getNameForVariant($value, $item);
                        $associatedProductIds[] = $this->updateConfigProduct($productData, $item, $name, $uomCode);
                        $associatedProductIds   = array_unique($associatedProductIds);
                    } catch (Exception $e) {
                        $this->logger->debug($e->getMessage());
                        $value->setData('is_failed', 1);
                    }
                } catch (NoSuchEntityException $e) {
                    $isVariantContainNull = $this->validateVariant($attributesCode, $value);
                    if ($isVariantContainNull) {
                        $this->logger->debug('Variant issue : Item ' . $value->getItemId() . '-' . $value->getVariantId() . ' contain null attribute');
                        $value->setData('is_updated', 0);
                        $value->setData('processed_at', $this->replicationHelper->getDateTime());
                        $value->setData('processed', 1);
                        $value->setData('is_failed', 1);
                        $this->replItemVariantRegistrationRepository->save($value);
                        continue;
                    }

                    $name                   = $this->getNameForVariant($value, $item);
                    $associatedProductIds[] = $this->createConfigProduct(
                        $name,
                        $item,
                        $value,
                        $uomCode,
                        $sku,
                        $configProduct,
                        $attributesCode,
                        $itemBarcodes
                    );
                }
                $value->setData('processed_at', $this->replicationHelper->getDateTime());
                $value->setData('processed', 1);
                $value->setData('is_updated', 0);
                $this->replItemVariantRegistrationRepository->save($value);
            }
        }

        // This is added to take care Magento Commerce PK
        $productId = $configProduct->getDataByKey('row_id');
        if (empty($productId)) {
            $productId = $configProduct->getId();
        }
        $position = 0;
        if ($configProduct->getTypeId() == Type::TYPE_SIMPLE || !empty($uomCodesNotProcessed)) {
            $attributeData     = [];
            $attributeIdsArray = $this->validateConfigurableAttributes($configProduct);
            foreach ($attributesCode as $value) {
                /** @var Interceptor $attribute */
                $attribute       = $this->eavConfig->getAttribute('catalog_product', $value);
                $attributesIds[] = $attribute->getId();
                $data            = [
                    'attribute_id' => $attribute->getId(),
                    'product_id'   => $productId,
                    'position'     => $position
                ];

                $attributeData[] = $this->getConfigurableAttributeData($attribute, $position);
                try {
                    if (!in_array($attribute->getId(), $attributeIdsArray)) {
                        // @codingStandardsIgnoreLine
                        $this->attribute->setData($data)->save();
                    }
                } catch (Exception $e) {
                    // @codingStandardsIgnoreLine
                    $this->logger->debug('Issue while saving Attribute Id : ' . $attribute->getId() . " and Product Id : $productId - " . $e->getMessage());
                }
                $position++;
            }
            $options = $this->optionsFactory->create($attributeData);
            $configProduct->getExtensionAttributes()->setConfigurableProductOptions($options);
        }
        $configProduct->setTypeId(Configurable::TYPE_CODE); // Setting Product Type As Configurable
        $configProduct->setAffectConfigurableProductAttributes($configProduct->getAttributeSetId());
        $this->configurable->setUsedProductAttributes($configProduct, $attributesIds);
        $configProduct->setNewVariationsAttributeSetId($configProduct->getAttributeSetId()); // Setting Attribute Set Id
        $configProduct->setConfigurableProductsData($configurableProductsData);
        $configProduct->setCanSaveConfigurableAttributes(true);
        $configProduct->setAssociatedProductIds($associatedProductIds); // Setting Associated Products
        try {
            $this->productRepository->save($configProduct);
        } catch (Exception $e) {
            $this->logger->debug("Exception while saving Configurable Product Id : $productId - " . $e->getMessage());
        }
    }

    /**
     * @param $itemId
     * @param $storeId
     * @param null $variantId
     * @return float|int
     */
    public function getInventoryStatus($itemId, $storeId, $variantId = null)
    {
        $qty     = 0;
        $filters = [
            ['field' => 'ItemId', 'value' => $itemId, 'condition_type' => 'eq'],
            ['field' => 'StoreId', 'value' => $storeId, 'condition_type' => 'eq'],
            ['field' => 'scope_id', 'value' => $this->store->getId(), 'condition_type' => 'eq']
        ];
        if (isset($variantId)) {
            $filters[] = ['field' => 'VariantId', 'value' => $variantId, 'condition_type' => 'eq'];
        } else {
            $filters[] = ['field' => 'VariantId', 'value' => true, 'condition_type' => 'null'];
        }
        $searchCriteria = $this->replicationHelper->buildCriteriaForDirect($filters, 1);
        /** @var ReplInvStatusRepository $inventoryStatus */
        $inventoryStatus = $this->replInvStatusRepository->getList($searchCriteria)->getItems();
        if (!empty($inventoryStatus)) {
            try {
                $inventoryStatus = reset($inventoryStatus);
                /** @var ReplInvStatus $inventoryStatus */
                $qty = $inventoryStatus->getQuantity();
            } catch (Exception $e) {
                $this->logger->debug($e->getMessage());
                $inventoryStatus->setData('is_failed', 1);
            }
            $inventoryStatus->setData('is_updated', 0);
            $inventoryStatus->setData('processed_at', $this->replicationHelper->getDateTime());
            $inventoryStatus->setData('processed', 1);
            $this->replInvStatusRepository->save($inventoryStatus);
        }
        return $qty;
    }

    /**
     * @param $value
     * @param $item
     * @return string
     */
    public function getNameForVariant(
        ReplItemVariantRegistration $value,
        ReplItem $item
    ) {
        $d1 = (($value->getVariantDimension1()) ?: '');
        $d2 = (($value->getVariantDimension2()) ?: '');
        $d3 = (($value->getVariantDimension3()) ?: '');
        $d4 = (($value->getVariantDimension4()) ?: '');
        $d5 = (($value->getVariantDimension5()) ?: '');
        $d6 = (($value->getVariantDimension6()) ?: '');

        /** @var ProductInterface $productV */
        $dMerged = (($d1) ? '-' . $d1 : '') . (($d2) ? '-' . $d2 : '') . (($d3) ? '-' . $d3 : '') .
            (($d4) ? '-' . $d4 : '') . (($d5) ? '-' . $d5 : '') . (($d6) ? '-' . $d6 : '');
        $name    = $item->getDescription() . $dMerged;
        return $name;
    }

    /**
     * @param $name
     * @param $description
     * @return string
     */
    public function getNameForUom($name, $description)
    {
        $name = $name . ' ' . $description;
        return $name;
    }

    /**
     * @param $sku
     * @return ProductInterface
     * @throws NoSuchEntityException
     */
    private function saveProductForWebsite($sku)
    {
        $productData     = $this->productRepository->get($sku, false, $this->store->getId());
        $websitesProduct = $productData->getWebsiteIds();
        /** Check if Item exist in the website and assign it if it does not exist*/
        if (!in_array($this->store->getWebsiteId(), $websitesProduct)) {
            $websitesProduct[] = $this->store->getWebsiteId();
            $productData->setWebsiteIds($websitesProduct)
                ->save();
        }

        return $productData;
    }

    /**
     * @param $productData
     * @param $item
     * @param $name
     * @param $attributesCode
     * @param $uomCode
     * @return int|null
     * @throws CouldNotSaveException
     * @throws InputException
     * @throws LocalizedException
     * @throws StateException
     */
    private function updateConfigProduct($productData, $item, $name, $uomCode = null)
    {
        $productData->setStoreId($this->store->getId());
        $productData->setName($name);
        $productData->setMetaTitle($name);
        $productData->setDescription($item->getDetails());
        $productData->setWeight($item->getGrossWeight());
        if (!empty($uomCode)) {
            $productData->setCustomAttribute("uom", $uomCode->getCode());
            $productData->setCustomAttribute(LSR::LS_UOM_ATTRIBUTE_QTY, $uomCode->getQtyPrUOM());
            $optionId = $this->_getOptionIDByCode(LSR::LS_UOM_ATTRIBUTE, $uomCode->getDescription());
            $productData->setData(LSR::LS_UOM_ATTRIBUTE, $optionId);
        } else {
            $productData->setCustomAttribute("uom", $item->getBaseUnitOfMeasure());
        }
        $productData->setStatus(Status::STATUS_ENABLED);
        try {
            // @codingStandardsIgnoreLine
            $productSaved = $this->productRepository->save($productData);
            return $productSaved->getId();
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }

    /**
     * @param $name
     * @param $item
     * @param $value
     * @param $uomCode
     * @param $sku
     * @param $configProduct
     * @param $attributesCode
     * @param $itemBarcodes
     * @return int|null
     * @throws CouldNotSaveException
     * @throws InputException
     * @throws LocalizedException
     * @throws StateException
     */
    private function createConfigProduct(
        $name,
        $item,
        $value,
        $uomCode,
        $sku,
        $configProduct,
        $attributesCode,
        $itemBarcodes
    ) {
        $productV = $this->productFactory->create();
        $productV->setName($name);
        $productV->setStoreId($this->store->getId());
        $productV->setWebsiteIds([$this->store->getWebsiteId()]);
        $productV->setMetaTitle($name);
        $productV->setDescription($item->getDetails());
        $productV->setSku($sku);
        $productV->setWeight($item->getGrossWeight());
        $unitOfMeasure = null;
        if (!empty($uomCode)) {
            if ($uomCode->getCode() != $item->getBaseUnitOfMeasure()) {
                $unitOfMeasure = $uomCode->getCode();
            }
        }
        if (isset($uomCode) && isset($value)) {
            $itemPrice = $this->getItemPrice($value->getItemId(), $value->getVariantId(), $unitOfMeasure);
            $itemSku   = $value->getItemId() . '-' . $value->getVariantId();
            $this->syncImagesForUom($itemSku, $productV);
        } elseif (isset($uomCode)) {
            $itemPrice = $this->getItemPrice($uomCode->getItemId(), null, $unitOfMeasure);
            $itemSku   = $uomCode->getItemId();
            $this->syncImagesForUom($itemSku, $productV);
        } else {
            $itemPrice = $this->getItemPrice($value->getItemId(), $value->getVariantId(), $unitOfMeasure);
        }
        if (isset($itemPrice)) {
            $productV->setPrice($itemPrice->getUnitPrice());
        } else {
            // Just in-case if we don't have price for Variant then in that case,
            // we are using the price of main product.
            $price = $this->getItemPrice($item->getNavId());
            if (!empty($price)) {
                $productV->setPrice($price->getUnitPrice());
            } else {
                $productV->setPrice($item->getUnitPrice());
            }
        }
        $productV->setAttributeSetId($configProduct->getAttributeSetId());
        $productV->setVisibility(Visibility::VISIBILITY_NOT_VISIBLE);
        $productV->setStatus(Status::STATUS_ENABLED);
        $productV->setTypeId(Type::TYPE_SIMPLE);
        if ($value) {
            $d1 = (($value->getVariantDimension1()) ?: '');
            $d2 = (($value->getVariantDimension2()) ?: '');
            $d3 = (($value->getVariantDimension3()) ?: '');
            $d4 = (($value->getVariantDimension4()) ?: '');
            $d5 = (($value->getVariantDimension5()) ?: '');
            $d6 = (($value->getVariantDimension6()) ?: '');
        }
        foreach ($attributesCode as $keyCode => $valueCode) {
            if ($valueCode == LSR::LS_UOM_ATTRIBUTE) {
                $optionValue = $uomCode->getDescription();
            } else {
                $optionValue = ${'d' . $keyCode};
            }
            if ((isset($keyCode) && $keyCode != '') || $keyCode == 0) {
                $optionId = $this->_getOptionIDByCode($valueCode, $optionValue);
                if (isset($optionId)) {
                    $productV->setData($valueCode, $optionId);
                }
            }
        }
        if ($uomCode) {
            $productV->setCustomAttribute('uom', $uomCode->getCode());
            $productV->setCustomAttribute(LSR::LS_UOM_ATTRIBUTE_QTY, $uomCode->getQtyPrUOM());
        } else {
            $productV->setCustomAttribute('uom', $item->getBaseUnitOfMeasure());
        }
        if (isset($itemBarcodes[$sku])) {
            $productV->setCustomAttribute('barcode', $itemBarcodes[$sku]);
        }
        if ($value) {
            $itemStock = $this->getInventoryStatus($value->getItemId(), $this->webStoreId, $value->getVariantId());
        } else {
            $itemStock = $this->getInventoryStatus($item->getNavId(), $this->webStoreId, null);
        }
        $productV->setStockData([
            'use_config_manage_stock' => 1,
            'is_in_stock'             => ($itemStock > 0) ? 1 : 0,
            'is_qty_decimal'          => 0,
            'qty'                     => $itemStock
        ]);
        try {
            /** @var ProductInterface $productSaved */
            // @codingStandardsIgnoreStart
            $productSaved = $this->productRepository->save($productV);
            return $productSaved->getId();
            // @codingStandardsIgnoreEnd
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }

    /**
     * @param $attributesCode
     * @param $value
     * @return bool
     */
    private function validateVariant($attributesCode, $value)
    {
        $isVariantContainNull = false;
        $d1                   = (($value->getVariantDimension1()) ?: '');
        $d2                   = (($value->getVariantDimension2()) ?: '');
        $d3                   = (($value->getVariantDimension3()) ?: '');
        $d4                   = (($value->getVariantDimension4()) ?: '');
        $d5                   = (($value->getVariantDimension5()) ?: '');
        $d6                   = (($value->getVariantDimension6()) ?: '');

        /** Check if all configurable attributes have value or not. */
        foreach ($attributesCode as $keyCode => $valueCode) {
            if (${'d' . $keyCode} == '' && $valueCode != LSR::LS_UOM_ATTRIBUTE) {
                // @codingStandardsIgnoreLine
                // Validation failed, that attribute contain some crappy data or null attribute which we does not need to process
                $isVariantContainNull = true;
                break;
            }
        }

        return $isVariantContainNull;
    }

    /**
     * @param $storeData
     * @return int
     */
    public function getRemainingRecords($storeData)
    {
        if (!$this->remainingRecords) {
            $criteria               = $this->replicationHelper->buildCriteriaForNewItems(
                'scope_id',
                $storeData->getId(),
                'eq',
                -1
            );
            $this->remainingRecords = $this->itemRepository->getList($criteria)->getTotalCount();
        }
        return $this->remainingRecords;
    }

    /**
     * @param $attribute
     * @param $position
     * @return array
     */
    public function getConfigurableAttributeData($attribute, $position)
    {
        $attributeValues = [];
        foreach ($attribute->getOptions() as $option) {
            if ($option->getValue()) {
                $attributeValues[] = [
                    'label'        => $option->getLabel(),
                    'attribute_id' => $attribute->getId(),
                    'value_index'  => $option->getValue(),
                ];
            }
        }
        return [
            'position'     => $position,
            'attribute_id' => $attribute->getId(),
            'label'        => $attribute->getName(),
            'values'       => $attributeValues
        ];
    }

    /**
     * @param $product
     * @param $disableStatus
     * @return mixed
     */
    public function setProductStatus($product, $disableStatus)
    {
        if ($disableStatus == 1) {
            $product->setStatus(Status::STATUS_DISABLED);
        } else {
            $product->setStatus(Status::STATUS_ENABLED);
        }

        return $product;
    }

    /**
     * @param $product
     */
    public function updateProductStatusGlobal($product)
    {
        try {
            $product->setStoreId(0);
            $product->getResource()->saveAttribute($product, 'status');
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * @param $name
     * @return int|null
     */
    public function getAttributeSetByName($name)
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter(
            'attribute_set_name',
            $name,
            'eq'
        )->setPageSize(1)->setCurrentPage(1);
        $result         = $this->attributeSetRepository->getList($searchCriteria->create());
        if ($result->getTotalCount()) {
            $items = $result->getItems();
            return reset($items)->getAttributeSetId();
        }
        return null;
    }

    /**
     * @param $name
     * @param $attributeSetId
     * @return int|null
     */
    public function getAttributeGroup($name, $attributeSetId)
    {
        $criteria = $this->searchCriteriaBuilder->setFilterGroups([]);
        $criteria->addFilter('attribute_group_name', $name, 'eq');
        $criteria->addFilter('attribute_set_id', $attributeSetId, 'eq');
        $criteria->setPageSize(1)->setCurrentPage(1);
        $searchCriteria = $criteria->create();

        $result = $this->attributeGroupRepository->getList($searchCriteria);
        if ($result->getTotalCount()) {
            $items = $result->getItems();
            return reset($items)->getAttributeGroupId();
        }
        return null;
    }

    /**
     * @param $attributeSetId
     * @param $attributeId
     * @return bool
     * @throws LocalizedException
     */
    public function checkAttributeInAttributeSet($attributeSetId, $attributeCode)
    {
        $collection = $this->eavAttributeCollectionFactory->create();
        $collection->setAttributeSetFilter($attributeSetId, Product::ENTITY);
        $collection->addFieldToFilter(
            'attribute_code',
            $attributeCode
        );
        if ($collection->getSize() > 0) {
            return false;
        }
        return true;
    }

    /**
     * @param $attributeSetId
     * @param $attributeGroupId
     * @return bool
     */
    public function getAttributeSortOrderInAttributeSet($attributeSetId, $attributeGroupId)
    {
        $collection = $this->eavAttributeCollectionFactory->create();
        $collection->setAttributeSetFilter($attributeSetId, Product::ENTITY);
        $collection->addFieldToFilter(
            'attribute_group_id',
            $attributeGroupId
        );
        $collection->setOrder('entity_attribute.sort_order', SortOrder::SORT_DESC);
        if ($collection->getSize() > 0) {
            $items = $collection->getItems();
            return reset($items)->getSortOrder() + 1;
        }
    }

    /**
     * @param ReplItem $item
     * @return int|null
     * @throws InputException
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function getAttributeSetId(ReplItem $item)
    {
        $attributeSetsMechanism = $this->replicationHelper->getAttributeSetsMechanism();
        if ($attributeSetsMechanism == LSR::SC_REPLICATION_ATTRIBUTE_SET_ITEM_CATEGORY_CODE) {
            $identifier = $item->getItemCategoryCode();
        } else {
            $identifier = $item->getProductGroupId();
        }
        if (!$identifier) {
            $identifier = LSR::SC_REPLICATION_ATTRIBUTE_SET_EXTRAS;
        }
        $formattedIdentifier = $this->replicationHelper->formatAttributeCode($identifier);
        if ($this->getAttributeSetByName($formattedIdentifier)) {
            $attributeSetId = $this->getAttributeSetByName($formattedIdentifier);
        } else {
            $attributes     = $this->getRelatedAttributesAssignedToGivenIdentifier(
                $attributeSetsMechanism,
                $identifier
            );
            $attributeSetId = $this->createAttributeSetAndGroupsAndReturnAttributeSetId(
                $formattedIdentifier,
                $attributes
            );
        }
        return $attributeSetId;
    }

    /**
     * @param $attributeSetsMechanism
     * @param $param
     * @return array
     */
    public function getRelatedAttributesAssignedToGivenIdentifier($attributeSetsMechanism, $param)
    {
        $attributes = [];
        if ($attributeSetsMechanism == LSR::SC_REPLICATION_ATTRIBUTE_SET_ITEM_CATEGORY_CODE) {
            if ($param == LSR::SC_REPLICATION_ATTRIBUTE_SET_EXTRAS) {
                $filter = ['field' => 'second.ItemCategoryCode', 'value' => true, 'condition_type' => 'null'];
            } else {
                $filter = ['field' => 'second.ItemCategoryCode', 'value' => $param, 'condition_type' => 'eq'];
            }
        } else {
            if ($param == LSR::SC_REPLICATION_ATTRIBUTE_SET_EXTRAS) {
                $filter = ['field' => 'second.ProductGroupId', 'value' => true, 'condition_type' => 'null'];
            } else {
                $filter = ['field' => 'second.ProductGroupId', 'value' => $param, 'condition_type' => 'eq'];
            }
        }
        $filters     = [$filter];
        $criteria    = $this->replicationHelper->buildCriteriaForDirect($filters, -1, false);
        $collection1 = $this->replAttributeValueCollectionFactory->create();
        $collection2 = $this->replExtendedVariantValueCollectionFactory->create();
        $this->replicationHelper->setCollectionPropertiesPlusJoin(
            $collection1,
            $criteria,
            'LinkField1',
            'ls_replication_repl_item',
            'nav_id'
        );
        $this->replicationHelper->setCollectionPropertiesPlusJoin(
            $collection2,
            $criteria,
            'ItemId',
            'ls_replication_repl_item',
            'nav_id'
        );
        $collection1->addFieldToSelect('Code');
        $collection1->getSelect()->group('main_table.Code');
        $collection2->addFieldToSelect('Code');
        $collection2->getSelect()->group('main_table.Code');
        $query1 = $collection1->getSelect()->__toString();
        $query2 = $collection2->getSelect()->__toString();
        if ($collection1->getSize() > 0) {
            foreach ($collection1 as $attribute) {
                $attributes['soft'][] = $attribute->getCode();
            }
        }
        if ($collection2->getSize() > 0) {
            foreach ($collection2 as $attribute) {
                $attributes['hard'][] = $attribute->getCode();
            }
        }
        return $attributes;
    }

    /**
     * @param $itemCategoryCode
     * @param array $attributes
     * @return int|null
     * @throws InputException
     * @throws NoSuchEntityException
     * @throws StateException
     */
    public function createAttributeSetAndGroupsAndReturnAttributeSetId($itemCategoryCode, array $attributes)
    {
        $entityTypeCode = Product::ENTITY;
        $entityType     = $this->eavTypeFactory->create()->loadByCode($entityTypeCode);
        $defaultSetId   = $entityType->getDefaultAttributeSetId();

        $attributeSet = $this->attributeSetFactory->create();
        $data         = [
            'attribute_set_name' => $itemCategoryCode,
            'entity_type_id'     => $entityType->getId(),
            'sort_order'         => 200,
        ];
        $attributeSet->setData($data);
        $attributeSet   = $this->attributeSetManagement->create($entityTypeCode, $attributeSet, $defaultSetId);
        $attributeGroup = $this->attributeSetGroupFactory->create();
        $attributeGroup->setAttributeSetId($attributeSet->getAttributeSetId());
        $attributeGroup->setAttributeGroupName(LSR::SC_REPLICATION_ATTRIBUTE_SET_SOFT_ATTRIBUTES_GROUP);
        $softAttributesGroup = $this->attributeGroupRepository->save($attributeGroup);
        $attributeGroup      = $this->attributeSetGroupFactory->create();
        $attributeGroup->setAttributeSetId($attributeSet->getAttributeSetId());
        $attributeGroup->setAttributeGroupName(LSR::SC_REPLICATION_ATTRIBUTE_SET_VARIANTS_ATTRIBUTES_GROUP);
        $hardAttributesGroup = $this->attributeGroupRepository->save($attributeGroup);

        foreach ($attributes as $type => $types) {
            foreach ($types as $attribute) {
                $formattedCode = $this->replicationHelper->formatAttributeCode($attribute);
                if ($type == 'soft') {
                    $this->attributeManagement->assign(
                        Product::ENTITY,
                        $attributeSet->getId(),
                        $softAttributesGroup->getAttributeGroupId(),
                        $formattedCode,
                        $attributeSet->getCollection()->count() * 10
                    );
                } else {
                    $this->attributeManagement->assign(
                        Product::ENTITY,
                        $attributeSet->getId(),
                        $hardAttributesGroup->getAttributeGroupId(),
                        $formattedCode,
                        $attributeSet->getCollection()->count() * 10
                    );
                }
            }
        }
        return $attributeSet->getAttributeSetId();
    }

    /**
     * @param $configProduct
     * @return array|null
     */
    public function validateConfigurableAttributes($configProduct)
    {
        $attributeIds        = [];
        $extensionAttributes = $configProduct->getExtensionAttributes();
        if ($extensionAttributes === null) {
            return $attributeIds;
        }
        $configurableOptions = (array)$extensionAttributes->getConfigurableProductOptions();

        /** @var OptionInterface $configurableOption */
        foreach ($configurableOptions as $configurableOption) {
            $attributeIds[] = $configurableOption->getAttributeId();
        }
        return $attributeIds;
    }

    /**
     * @param $existingProduct
     * @param $uomProduct
     */
    public function syncImagesForUom($existingProduct, $uomProduct)
    {
        try {
            try {
                $product = $this->productRepository->get($existingProduct);
            } catch (NoSuchEntityException $e) {
                return;
            }
            //Assign image from the already created product to the uom product
            $images = $product->getMediaGalleryImages();
            foreach ($images as $image) {
                if ($path = $image->getPath()) {
                    $uomProduct->addImageToMediaGallery(
                        $path,
                        ['image', 'thumbnail', 'small_image'],
                        false,
                        false
                    );
                }
            }
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
