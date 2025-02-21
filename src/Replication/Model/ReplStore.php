<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Replication\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;
use Ls\Replication\Api\Data\ReplStoreInterface;

class ReplStore extends AbstractModel implements ReplStoreInterface, IdentityInterface
{
    public const CACHE_TAG = 'ls_replication_repl_store';

    protected $_cacheTag = 'ls_replication_repl_store';

    protected $_eventPrefix = 'ls_replication_repl_store';

    /**
     * @property string $City
     */
    protected $City = null;

    /**
     * @property boolean $ClickAndCollect
     */
    protected $ClickAndCollect = null;

    /**
     * @property string $Country
     */
    protected $Country = null;

    /**
     * @property string $County
     */
    protected $County = null;

    /**
     * @property string $CultureName
     */
    protected $CultureName = null;

    /**
     * @property string $Currency
     */
    protected $Currency = null;

    /**
     * @property string $DefaultCustomerAccount
     */
    protected $DefaultCustomerAccount = null;

    /**
     * @property string $FunctionalityProfile
     */
    protected $FunctionalityProfile = null;

    /**
     * @property string $HospSalesTypes
     */
    protected $HospSalesTypes = null;

    /**
     * @property string $nav_id
     */
    protected $nav_id = null;

    /**
     * @property boolean $IsDeleted
     */
    protected $IsDeleted = null;

    /**
     * @property float $Latitute
     */
    protected $Latitute = null;

    /**
     * @property float $Longitude
     */
    protected $Longitude = null;

    /**
     * @property string $MainMenuID
     */
    protected $MainMenuID = null;

    /**
     * @property string $Name
     */
    protected $Name = null;

    /**
     * @property string $Phone
     */
    protected $Phone = null;

    /**
     * @property string $State
     */
    protected $State = null;

    /**
     * @property string $Street
     */
    protected $Street = null;

    /**
     * @property string $TaxGroup
     */
    protected $TaxGroup = null;

    /**
     * @property boolean $UseSourcingLocation
     */
    protected $UseSourcingLocation = null;

    /**
     * @property int $UserDefaultCustomerAccount
     */
    protected $UserDefaultCustomerAccount = null;

    /**
     * @property string $ZipCode
     */
    protected $ZipCode = null;

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
        $this->_init( 'Ls\Replication\Model\ResourceModel\ReplStore' );
    }

    public function getIdentities()
    {
        return [ self::CACHE_TAG . '_' . $this->getId() ];
    }

    /**
     * @param string $City
     * @return $this
     */
    public function setCity($City)
    {
        $this->setData( 'City', $City );
        $this->City = $City;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->getData( 'City' );
    }

    /**
     * @param boolean $ClickAndCollect
     * @return $this
     */
    public function setClickAndCollect($ClickAndCollect)
    {
        $this->setData( 'ClickAndCollect', $ClickAndCollect );
        $this->ClickAndCollect = $ClickAndCollect;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return boolean
     */
    public function getClickAndCollect()
    {
        return $this->getData( 'ClickAndCollect' );
    }

    /**
     * @param string $Country
     * @return $this
     */
    public function setCountry($Country)
    {
        $this->setData( 'Country', $Country );
        $this->Country = $Country;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->getData( 'Country' );
    }

    /**
     * @param string $County
     * @return $this
     */
    public function setCounty($County)
    {
        $this->setData( 'County', $County );
        $this->County = $County;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getCounty()
    {
        return $this->getData( 'County' );
    }

    /**
     * @param string $CultureName
     * @return $this
     */
    public function setCultureName($CultureName)
    {
        $this->setData( 'CultureName', $CultureName );
        $this->CultureName = $CultureName;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getCultureName()
    {
        return $this->getData( 'CultureName' );
    }

    /**
     * @param string $Currency
     * @return $this
     */
    public function setCurrency($Currency)
    {
        $this->setData( 'Currency', $Currency );
        $this->Currency = $Currency;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->getData( 'Currency' );
    }

    /**
     * @param string $DefaultCustomerAccount
     * @return $this
     */
    public function setDefaultCustomerAccount($DefaultCustomerAccount)
    {
        $this->setData( 'DefaultCustomerAccount', $DefaultCustomerAccount );
        $this->DefaultCustomerAccount = $DefaultCustomerAccount;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultCustomerAccount()
    {
        return $this->getData( 'DefaultCustomerAccount' );
    }

    /**
     * @param string $FunctionalityProfile
     * @return $this
     */
    public function setFunctionalityProfile($FunctionalityProfile)
    {
        $this->setData( 'FunctionalityProfile', $FunctionalityProfile );
        $this->FunctionalityProfile = $FunctionalityProfile;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getFunctionalityProfile()
    {
        return $this->getData( 'FunctionalityProfile' );
    }

    /**
     * @param string $HospSalesTypes
     * @return $this
     */
    public function setHospSalesTypes($HospSalesTypes)
    {
        $this->setData( 'HospSalesTypes', $HospSalesTypes );
        $this->HospSalesTypes = $HospSalesTypes;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getHospSalesTypes()
    {
        return $this->getData( 'HospSalesTypes' );
    }

    /**
     * @param string $nav_id
     * @return $this
     */
    public function setNavId($nav_id)
    {
        $this->setData( 'nav_id', $nav_id );
        $this->nav_id = $nav_id;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getNavId()
    {
        return $this->getData( 'nav_id' );
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
     * @param float $Latitute
     * @return $this
     */
    public function setLatitute($Latitute)
    {
        $this->setData( 'Latitute', $Latitute );
        $this->Latitute = $Latitute;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return float
     */
    public function getLatitute()
    {
        return $this->getData( 'Latitute' );
    }

    /**
     * @param float $Longitude
     * @return $this
     */
    public function setLongitude($Longitude)
    {
        $this->setData( 'Longitude', $Longitude );
        $this->Longitude = $Longitude;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->getData( 'Longitude' );
    }

    /**
     * @param string $MainMenuID
     * @return $this
     */
    public function setMainMenuID($MainMenuID)
    {
        $this->setData( 'MainMenuID', $MainMenuID );
        $this->MainMenuID = $MainMenuID;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getMainMenuID()
    {
        return $this->getData( 'MainMenuID' );
    }

    /**
     * @param string $Name
     * @return $this
     */
    public function setName($Name)
    {
        $this->setData( 'Name', $Name );
        $this->Name = $Name;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getData( 'Name' );
    }

    /**
     * @param string $Phone
     * @return $this
     */
    public function setPhone($Phone)
    {
        $this->setData( 'Phone', $Phone );
        $this->Phone = $Phone;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->getData( 'Phone' );
    }

    /**
     * @param string $State
     * @return $this
     */
    public function setState($State)
    {
        $this->setData( 'State', $State );
        $this->State = $State;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->getData( 'State' );
    }

    /**
     * @param string $Street
     * @return $this
     */
    public function setStreet($Street)
    {
        $this->setData( 'Street', $Street );
        $this->Street = $Street;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->getData( 'Street' );
    }

    /**
     * @param string $TaxGroup
     * @return $this
     */
    public function setTaxGroup($TaxGroup)
    {
        $this->setData( 'TaxGroup', $TaxGroup );
        $this->TaxGroup = $TaxGroup;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getTaxGroup()
    {
        return $this->getData( 'TaxGroup' );
    }

    /**
     * @param boolean $UseSourcingLocation
     * @return $this
     */
    public function setUseSourcingLocation($UseSourcingLocation)
    {
        $this->setData( 'UseSourcingLocation', $UseSourcingLocation );
        $this->UseSourcingLocation = $UseSourcingLocation;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return boolean
     */
    public function getUseSourcingLocation()
    {
        return $this->getData( 'UseSourcingLocation' );
    }

    /**
     * @param int $UserDefaultCustomerAccount
     * @return $this
     */
    public function setUserDefaultCustomerAccount($UserDefaultCustomerAccount)
    {
        $this->setData( 'UserDefaultCustomerAccount', $UserDefaultCustomerAccount );
        $this->UserDefaultCustomerAccount = $UserDefaultCustomerAccount;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return int
     */
    public function getUserDefaultCustomerAccount()
    {
        return $this->getData( 'UserDefaultCustomerAccount' );
    }

    /**
     * @param string $ZipCode
     * @return $this
     */
    public function setZipCode($ZipCode)
    {
        $this->setData( 'ZipCode', $ZipCode );
        $this->ZipCode = $ZipCode;
        $this->setDataChanges( TRUE );
        return $this;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->getData( 'ZipCode' );
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

