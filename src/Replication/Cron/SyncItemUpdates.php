<?php

namespace Ls\Replication\Cron;

use Exception;
use \Ls\Core\Model\LSR;
use \Ls\Omni\Client\Ecommerce\Entity\ReplHierarchyLeaf;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Cron class to work on Hierarchy leaf changes
 */
class SyncItemUpdates extends ProductCreateTask
{
    /** @var bool */
    public $cronStatus = false;

    /** @var int */
    public $remainingRecords;

    /**
     * @inheritDoc
     */
    public function execute($storeData = null)
    {
        if (!empty($storeData) && $storeData instanceof StoreInterface) {
            $stores = [$storeData];
        } else {
            /** @var StoreInterface[] $stores */
            $stores = $this->lsr->getAllStores();
        }
        if (!empty($stores)) {
            foreach ($stores as $store) {
                $this->lsr->setStoreId($store->getId());
                $this->store = $store;
                if ($this->lsr->isLSR($this->store->getId())) {
                    $cronCategoryCheck              = $this->lsr->getConfigValueFromDb(
                        LSR::SC_SUCCESS_CRON_CATEGORY,
                        ScopeInterface::SCOPE_STORES,
                        $store->getId()
                    );

                    if ($cronCategoryCheck == 1) {
                        $this->logger->debug('Running SyncItemUpdates Task for store ' . $this->store->getName());
                        $this->replicationHelper->updateConfigValue(
                            $this->replicationHelper->getDateTime(),
                            LSR::SC_ITEM_UPDATES_CONFIG_PATH_LAST_EXECUTE,
                            $this->store->getId()
                        );
                        $hierarchyCode = $this->lsr->getStoreConfig(
                            LSR::SC_REPLICATION_HIERARCHY_CODE,
                            $this->store->getId()
                        );
                        if (!empty($hierarchyCode)) {
                            $itemAssignmentCount = $this->caterItemAssignmentToCategories();
                            $this->caterHierarchyLeafRemoval($hierarchyCode);
                            if ($itemAssignmentCount == 0) {
                                $this->cronStatus = true;
                            }
                        } else {
                            $this->logger->debug('Hierarchy Code not defined in the configuration.');
                        }

                        $this->replicationHelper->updateCronStatus(
                            $this->cronStatus,
                            LSR::SC_SUCCESS_CRON_ITEM_UPDATES,
                            $this->store->getId()
                        );
                        $this->logger->debug('End SyncItemUpdates Task for store ' . $this->store->getName());
                    }
                }
                $this->lsr->setStoreId(null);
            }
        }
    }

    /**
     * Execute Manually
     *
     * @param null $storeData
     * @return array|int[]
     * @throws InputException
     * @throws LocalizedException
     */
    public function executeManually($storeData = null)
    {
        $this->execute($storeData);
        $itemsLeftToProcess = (int)$this->getRemainingRecords($storeData);
        return [$itemsLeftToProcess];
    }

    /**
     * Cater Item assignment to Categories
     *
     * @return int
     */
    public function caterItemAssignmentToCategories()
    {
        $assignProductToCategoryBatchSize = $this->replicationHelper->getProductCategoryAssignmentBatchSize();

        $filters = [
            ['field' => 'Type', 'value' => 'Deal', 'condition_type' => 'neq'],
            ['field' => 'scope_id', 'value' => $this->store->getId(), 'condition_type' => 'eq']
        ];

        $criteria = $this->replicationHelper->buildCriteriaForArrayWithAlias(
            $filters,
            $assignProductToCategoryBatchSize
        );
        /** @var  $collection */
        $collection = $this->replHierarchyLeafCollectionFactory->create();
        $this->replicationHelper->setCollectionPropertiesPlusJoinSku(
            $collection,
            $criteria,
            'nav_id',
            null,
            'catalog_product_entity',
            'sku'
        );
        $sku = '';
        $query = $collection->getSelect()->__toString();
        if ($collection->getSize() > 0) {
            foreach ($collection as $hierarchyLeaf) {
                try {
                    $sku     = $hierarchyLeaf->getNavId();
                    $product = $this->productRepository->get($hierarchyLeaf->getNavId());
                    $this->replicationHelper->assignProductToCategories($product, $this->store);
                } catch (Exception $e) {
                    $this->logger->debug('Problem with sku: ' . $sku . ' in ' . __METHOD__);
                    $this->logger->debug($e->getMessage());
                }
            }
            return (int)$this->getRemainingRecords($this->store);
        } else {
            return (int)$collection->getSize();
        }
    }

    /**
     * Cater hierarchy leaf removal
     *
     * @param $hierarchyCode
     * @return mixed
     */
    public function caterHierarchyLeafRemoval($hierarchyCode)
    {
        $filters    = [
            ['field' => 'main_table.HierarchyCode', 'value' => $hierarchyCode, 'condition_type' => 'eq'],
            ['field' => 'main_table.scope_id', 'value' => $this->store->getId(), 'condition_type' => 'eq']
        ];
        $criteria   = $this->replicationHelper->buildCriteriaGetDeletedOnlyWithAlias($filters, 100);
        $collection = $this->replHierarchyLeafCollectionFactory->create();
        $this->replicationHelper->setCollectionPropertiesPlusJoin(
            $collection,
            $criteria,
            'nav_id',
            'catalog_product_entity',
            'sku',
            true
        );
        $sku = '';
        /** @var ReplHierarchyLeaf $hierarchyLeaf */
        foreach ($collection as $hierarchyLeaf) {
            try {
                $sku               = $hierarchyLeaf->getNavId();
                $product           = $this->productRepository->get($sku);
                $categories        = $product->getCategoryIds();
                $categoryExistData = $this->isCategoryExist($hierarchyLeaf->getNodeId());
                if (!empty($categoryExistData)) {
                    $categoryId       = $categoryExistData->getEntityId();
                    $parentCategoryId = $categoryExistData->getParentId();
                    if (in_array($categoryId, $categories)) {
                        $this->categoryLinkRepositoryInterface->deleteByIds($categoryId, $sku);
                        $catIndex = array_search($categoryId, $categories);
                        if ($catIndex !== false) {
                            unset($categories[$catIndex]);
                        }
                    }
                    if (in_array($parentCategoryId, $categories)) {
                        $childCategories = $this->categoryRepository->get($parentCategoryId)->getChildren();
                        $childCat        = explode(",", $childCategories);
                        if (count(array_intersect($childCat, $categories)) == 0) {
                            $this->categoryLinkRepositoryInterface->deleteByIds($parentCategoryId, $sku);
                        }
                    }
                }
            } catch (Exception $e) {
                $this->logger->debug('Problem with sku: ' . $sku . ' in ' . __METHOD__);
                $this->logger->debug($e->getMessage());
            }
            $hierarchyLeaf->setData('processed', 1);
            $hierarchyLeaf->setData('processed_at', $this->replicationHelper->getDateTime());
            $hierarchyLeaf->setData('is_updated', 0);
            // @codingStandardsIgnoreStart
            $this->replHierarchyLeafRepository->save($hierarchyLeaf);
            // @codingStandardsIgnoreEnd
        }
        return $collection->getSize();
    }

    /**
     * Is category exist
     *
     * @param $nav_id
     * @return false|DataObject
     * @throws LocalizedException
     */
    public function isCategoryExist($nav_id)
    {
        $collection = $this->collectionFactory->create()
            ->addAttributeToFilter('nav_id', $nav_id)
            ->setPageSize(1);
        if ($collection->getSize()) {
            // @codingStandardsIgnoreStart
            return $collection->getFirstItem();
            // @codingStandardsIgnoreEnd
        }
        return false;
    }

    /**
     * Get remaining records
     *
     * @param $storeData
     * @return int
     */
    public function getRemainingRecords($storeData)
    {
        if (!$this->remainingRecords) {
            $filters = [
                ['field' => 'Type', 'value' => 'Deal', 'condition_type' => 'neq'],
                ['field' => 'scope_id', 'value' => $this->store->getId(), 'condition_type' => 'eq']
            ];
            $criteria = $this->replicationHelper->buildCriteriaForArrayWithAlias(
                $filters,
                -1
            );
            /** @var  $collection */
            $collection = $this->replHierarchyLeafCollectionFactory->create();
            $this->replicationHelper->setCollectionPropertiesPlusJoinSku(
                $collection,
                $criteria,
                'nav_id',
                null,
                'catalog_product_entity',
                'sku'
            );
            $this->remainingRecords = $collection->getSize();
        }
        return $this->remainingRecords;
    }
}
