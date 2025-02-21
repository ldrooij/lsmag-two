<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Replication\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Ls\Replication\Api\Data\ReplItemVariantRegistrationInterface;

class ReplItemVariantRegistration extends AbstractModel implements ReplItemVariantRegistrationInterface, IdentityInterface
{
    public const CACHE_TAG = 'ls_replication_repl_item_variant_registration';

    protected $_cacheTag = 'ls_replication_repl_item_variant_registration';

    protected $_eventPrefix = 'ls_replication_repl_item_variant_registration';

    /**
     * @property int $BlockedOnECom
     */
    protected $BlockedOnECom = null;

    /**
     * @property int $BlockedOnPos
     */
    protected $BlockedOnPos = null;

    /**
     * @property string $FrameworkCode
     */
    protected $FrameworkCode = null;

    /**
     * @property boolean $IsDeleted
     */
    protected $IsDeleted = null;

    /**
     * @property string $ItemId
     */
    protected $ItemId = null;

    /**
     * @property string $VariantDimension1
     */
    protected $VariantDimension1 = null;

    /**
     * @property string $VariantDimension2
     */
    protected $VariantDimension2 = null;

    /**
     * @property string $VariantDimension3
     */
    protected $VariantDimension3 = null;

    /**
     * @property string $VariantDimension4
     */
    protected $VariantDimension4 = null;

    /**
     * @property string $VariantDimension5
     */
    protected $VariantDimension5 = null;

    /**
     * @property string $VariantDimension6
     */
    protected $VariantDimension6 = null;

    /**
     * @property string $VariantId
     */
    protected $VariantId = null;

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
        $this->_init( 'Ls\Replication\Model\ResourceModel\ReplItemVariantRegistration' );
    }

    public function getIdentities()
    {
        return [ self::CACHE_TAG . '_' . $this->getId() ];
    }

    /**
     * @param int $BlockedOnECom
     * @return $this
     */
    public function setBlockedOnECom($BlockedOnECom)
    {
        $this->setData( 'BlockedOnECom', $BlockedOnECom );
        $this->BlockedOnECom = $BlockedOnECom;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return int
     */
    public function getBlockedOnECom()
    {
        return $this->getData( 'BlockedOnECom' );
    }

    /**
     * @param int $BlockedOnPos
     * @return $this
     */
    public function setBlockedOnPos($BlockedOnPos)
    {
        $this->setData( 'BlockedOnPos', $BlockedOnPos );
        $this->BlockedOnPos = $BlockedOnPos;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return int
     */
    public function getBlockedOnPos()
    {
        return $this->getData( 'BlockedOnPos' );
    }

    /**
     * @param string $FrameworkCode
     * @return $this
     */
    public function setFrameworkCode($FrameworkCode)
    {
        $this->setData( 'FrameworkCode', $FrameworkCode );
        $this->FrameworkCode = $FrameworkCode;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getFrameworkCode()
    {
        return $this->getData( 'FrameworkCode' );
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
     * @param string $VariantDimension1
     * @return $this
     */
    public function setVariantDimension1($VariantDimension1)
    {
        $this->setData( 'VariantDimension1', $VariantDimension1 );
        $this->VariantDimension1 = $VariantDimension1;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getVariantDimension1()
    {
        return $this->getData( 'VariantDimension1' );
    }

    /**
     * @param string $VariantDimension2
     * @return $this
     */
    public function setVariantDimension2($VariantDimension2)
    {
        $this->setData( 'VariantDimension2', $VariantDimension2 );
        $this->VariantDimension2 = $VariantDimension2;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getVariantDimension2()
    {
        return $this->getData( 'VariantDimension2' );
    }

    /**
     * @param string $VariantDimension3
     * @return $this
     */
    public function setVariantDimension3($VariantDimension3)
    {
        $this->setData( 'VariantDimension3', $VariantDimension3 );
        $this->VariantDimension3 = $VariantDimension3;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getVariantDimension3()
    {
        return $this->getData( 'VariantDimension3' );
    }

    /**
     * @param string $VariantDimension4
     * @return $this
     */
    public function setVariantDimension4($VariantDimension4)
    {
        $this->setData( 'VariantDimension4', $VariantDimension4 );
        $this->VariantDimension4 = $VariantDimension4;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getVariantDimension4()
    {
        return $this->getData( 'VariantDimension4' );
    }

    /**
     * @param string $VariantDimension5
     * @return $this
     */
    public function setVariantDimension5($VariantDimension5)
    {
        $this->setData( 'VariantDimension5', $VariantDimension5 );
        $this->VariantDimension5 = $VariantDimension5;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getVariantDimension5()
    {
        return $this->getData( 'VariantDimension5' );
    }

    /**
     * @param string $VariantDimension6
     * @return $this
     */
    public function setVariantDimension6($VariantDimension6)
    {
        $this->setData( 'VariantDimension6', $VariantDimension6 );
        $this->VariantDimension6 = $VariantDimension6;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getVariantDimension6()
    {
        return $this->getData( 'VariantDimension6' );
    }

    /**
     * @param string $VariantId
     * @return $this
     */
    public function setVariantId($VariantId)
    {
        $this->setData( 'VariantId', $VariantId );
        $this->VariantId = $VariantId;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getVariantId()
    {
        return $this->getData( 'VariantId' );
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

