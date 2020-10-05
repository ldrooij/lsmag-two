<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Replication\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Ls\Replication\Api\Data\ReplItemUnitOfMeasureInterface;

class ReplItemUnitOfMeasure extends AbstractModel implements ReplItemUnitOfMeasureInterface, IdentityInterface
{

    public const CACHE_TAG = 'ls_replication_repl_item_unit_of_measure';

    protected $_cacheTag = 'ls_replication_repl_item_unit_of_measure';

    protected $_eventPrefix = 'ls_replication_repl_item_unit_of_measure';

    /**
     * @property string $Code
     */
    protected $Code = null;

    /**
     * @property boolean $CountAsOne
     */
    protected $CountAsOne = null;

    /**
     * @property string $Description
     */
    protected $Description = null;

    /**
     * @property boolean $IsDeleted
     */
    protected $IsDeleted = null;

    /**
     * @property string $ItemId
     */
    protected $ItemId = null;

    /**
     * @property int $Order
     */
    protected $Order = null;

    /**
     * @property float $QtyPrUOM
     */
    protected $QtyPrUOM = null;

    /**
     * @property int $Selection
     */
    protected $Selection = null;

    /**
     * @property string $ShortDescription
     */
    protected $ShortDescription = null;

    /**
     * @property string $scope
     */
    protected $scope = null;

    /**
     * @property int $scope_id
     */
    protected $scope_id = null;

    /**
     * @property boolean $processed
     */
    protected $processed = null;

    /**
     * @property boolean $is_updated
     */
    protected $is_updated = null;

    /**
     * @property boolean $is_failed
     */
    protected $is_failed = null;

    /**
     * @property string $created_at
     */
    protected $created_at = null;

    /**
     * @property string $updated_at
     */
    protected $updated_at = null;

    /**
     * @property string $checksum
     */
    protected $checksum = null;

    /**
     * @property string $processed_at
     */
    protected $processed_at = null;

    public function _construct()
    {
        $this->_init( 'Ls\Replication\Model\ResourceModel\ReplItemUnitOfMeasure' );
    }

    public function getIdentities()
    {
        return [ self::CACHE_TAG . '_' . $this->getId() ];
    }

    /**
     * @param string $Code
     * @return $this
     */
    public function setCode($Code)
    {
        $this->setData( 'Code', $Code );
        $this->Code = $Code;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->getData( 'Code' );
    }

    /**
     * @param boolean $CountAsOne
     * @return $this
     */
    public function setCountAsOne($CountAsOne)
    {
        $this->setData( 'CountAsOne', $CountAsOne );
        $this->CountAsOne = $CountAsOne;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return boolean
     */
    public function getCountAsOne()
    {
        return $this->getData( 'CountAsOne' );
    }

    /**
     * @param string $Description
     * @return $this
     */
    public function setDescription($Description)
    {
        $this->setData( 'Description', $Description );
        $this->Description = $Description;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->getData( 'Description' );
    }

    /**
     * @param boolean $IsDeleted
     * @return $this
     */
    public function setIsDeleted($IsDeleted)
    {
        $this->setData( 'IsDeleted', $IsDeleted );
        $this->IsDeleted = $IsDeleted;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->getData( 'IsDeleted' );
    }

    /**
     * @param string $ItemId
     * @return $this
     */
    public function setItemId($ItemId)
    {
        $this->setData( 'ItemId', $ItemId );
        $this->ItemId = $ItemId;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getItemId()
    {
        return $this->getData( 'ItemId' );
    }

    /**
     * @param int $Order
     * @return $this
     */
    public function setOrder($Order)
    {
        $this->setData( 'Order', $Order );
        $this->Order = $Order;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->getData( 'Order' );
    }

    /**
     * @param float $QtyPrUOM
     * @return $this
     */
    public function setQtyPrUOM($QtyPrUOM)
    {
        $this->setData( 'QtyPrUOM', $QtyPrUOM );
        $this->QtyPrUOM = $QtyPrUOM;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return float
     */
    public function getQtyPrUOM()
    {
        return $this->getData( 'QtyPrUOM' );
    }

    /**
     * @param int $Selection
     * @return $this
     */
    public function setSelection($Selection)
    {
        $this->setData( 'Selection', $Selection );
        $this->Selection = $Selection;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return int
     */
    public function getSelection()
    {
        return $this->getData( 'Selection' );
    }

    /**
     * @param string $ShortDescription
     * @return $this
     */
    public function setShortDescription($ShortDescription)
    {
        $this->setData( 'ShortDescription', $ShortDescription );
        $this->ShortDescription = $ShortDescription;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->getData( 'ShortDescription' );
    }

    /**
     * @param string $scope
     * @return $this
     */
    public function setScope($scope)
    {
        $this->setData( 'scope', $scope );
        $this->scope = $scope;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getScope()
    {
        return $this->getData( 'scope' );
    }

    /**
     * @param int $scope_id
     * @return $this
     */
    public function setScopeId($scope_id)
    {
        $this->setData( 'scope_id', $scope_id );
        $this->scope_id = $scope_id;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return int
     */
    public function getScopeId()
    {
        return $this->getData( 'scope_id' );
    }

    /**
     * @param boolean $processed
     * @return $this
     */
    public function setProcessed($processed)
    {
        $this->setData( 'processed', $processed );
        $this->processed = $processed;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return boolean
     */
    public function getProcessed()
    {
        return $this->getData( 'processed' );
    }

    /**
     * @param boolean $is_updated
     * @return $this
     */
    public function setIsUpdated($is_updated)
    {
        $this->setData( 'is_updated', $is_updated );
        $this->is_updated = $is_updated;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsUpdated()
    {
        return $this->getData( 'is_updated' );
    }

    /**
     * @param boolean $is_failed
     * @return $this
     */
    public function setIsFailed($is_failed)
    {
        $this->setData( 'is_failed', $is_failed );
        $this->is_failed = $is_failed;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsFailed()
    {
        return $this->getData( 'is_failed' );
    }

    /**
     * @param string $created_at
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->setData( 'created_at', $created_at );
        $this->created_at = $created_at;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData( 'created_at' );
    }

    /**
     * @param string $updated_at
     * @return $this
     */
    public function setUpdatedAt($updated_at)
    {
        $this->setData( 'updated_at', $updated_at );
        $this->updated_at = $updated_at;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData( 'updated_at' );
    }

    /**
     * @param string $checksum
     * @return $this
     */
    public function setChecksum($checksum)
    {
        $this->setData( 'checksum', $checksum );
        $this->checksum = $checksum;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getChecksum()
    {
        return $this->getData( 'checksum' );
    }

    /**
     * @param string $processed_at
     * @return $this
     */
    public function setProcessedAt($processed_at)
    {
        $this->setData( 'processed_at', $processed_at );
        $this->processed_at = $processed_at;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getProcessedAt()
    {
        return $this->getData( 'processed_at' );
    }


}

