<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use Ls\Omni\Client\Ecommerce\Entity\Enum\ListType;
use Ls\Omni\Exception\InvalidEnumException;

class OneList extends Entity
{

    /**
     * @property ArrayOfOneListLink $CardLinks
     */
    protected $CardLinks = null;

    /**
     * @property ArrayOfOneListItem $Items
     */
    protected $Items = null;

    /**
     * @property ArrayOfOneListPublishedOffer $PublishedOffers
     */
    protected $PublishedOffers = null;

    /**
     * @property string $CardId
     */
    protected $CardId = null;

    /**
     * @property string $CreateDate
     */
    protected $CreateDate = null;

    /**
     * @property string $Description
     */
    protected $Description = null;

    /**
     * @property int $ExternalType
     */
    protected $ExternalType = null;

    /**
     * @property boolean $IsHospitality
     */
    protected $IsHospitality = null;

    /**
     * @property ListType $ListType
     */
    protected $ListType = null;

    /**
     * @property float $PointAmount
     */
    protected $PointAmount = null;

    /**
     * @property string $SalesType
     */
    protected $SalesType = null;

    /**
     * @property string $ShipToCountryCode
     */
    protected $ShipToCountryCode = null;

    /**
     * @property float $ShippingAmount
     */
    protected $ShippingAmount = null;

    /**
     * @property string $StoreId
     */
    protected $StoreId = null;

    /**
     * @property float $TotalAmount
     */
    protected $TotalAmount = null;

    /**
     * @property float $TotalDiscAmount
     */
    protected $TotalDiscAmount = null;

    /**
     * @property float $TotalNetAmount
     */
    protected $TotalNetAmount = null;

    /**
     * @property float $TotalTaxAmount
     */
    protected $TotalTaxAmount = null;

    /**
     * @param ArrayOfOneListLink $CardLinks
     * @return $this
     */
    public function setCardLinks($CardLinks)
    {
        $this->CardLinks = $CardLinks;
        return $this;
    }

    /**
     * @return ArrayOfOneListLink
     */
    public function getCardLinks()
    {
        return $this->CardLinks;
    }

    /**
     * @param ArrayOfOneListItem $Items
     * @return $this
     */
    public function setItems($Items)
    {
        $this->Items = $Items;
        return $this;
    }

    /**
     * @return ArrayOfOneListItem
     */
    public function getItems()
    {
        return $this->Items;
    }

    /**
     * @param ArrayOfOneListPublishedOffer $PublishedOffers
     * @return $this
     */
    public function setPublishedOffers($PublishedOffers)
    {
        $this->PublishedOffers = $PublishedOffers;
        return $this;
    }

    /**
     * @return ArrayOfOneListPublishedOffer
     */
    public function getPublishedOffers()
    {
        return $this->PublishedOffers;
    }

    /**
     * @param string $CardId
     * @return $this
     */
    public function setCardId($CardId)
    {
        $this->CardId = $CardId;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardId()
    {
        return $this->CardId;
    }

    /**
     * @param string $CreateDate
     * @return $this
     */
    public function setCreateDate($CreateDate)
    {
        $this->CreateDate = $CreateDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreateDate()
    {
        return $this->CreateDate;
    }

    /**
     * @param string $Description
     * @return $this
     */
    public function setDescription($Description)
    {
        $this->Description = $Description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * @param int $ExternalType
     * @return $this
     */
    public function setExternalType($ExternalType)
    {
        $this->ExternalType = $ExternalType;
        return $this;
    }

    /**
     * @return int
     */
    public function getExternalType()
    {
        return $this->ExternalType;
    }

    /**
     * @param boolean $IsHospitality
     * @return $this
     */
    public function setIsHospitality($IsHospitality)
    {
        $this->IsHospitality = $IsHospitality;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsHospitality()
    {
        return $this->IsHospitality;
    }

    /**
     * @param ListType|string $ListType
     * @return $this
     * @throws InvalidEnumException
     */
    public function setListType($ListType)
    {
        if ( ! $ListType instanceof ListType ) {
            if ( ListType::isValid( $ListType ) )
                $ListType = new ListType( $ListType );
            elseif ( ListType::isValidKey( $ListType ) )
                $ListType = new ListType( constant( "ListType::$ListType" ) );
            elseif ( ! $ListType instanceof ListType )
                throw new InvalidEnumException();
        }
        $this->ListType = $ListType->getValue();

        return $this;
    }

    /**
     * @return ListType
     */
    public function getListType()
    {
        return $this->ListType;
    }

    /**
     * @param float $PointAmount
     * @return $this
     */
    public function setPointAmount($PointAmount)
    {
        $this->PointAmount = $PointAmount;
        return $this;
    }

    /**
     * @return float
     */
    public function getPointAmount()
    {
        return $this->PointAmount;
    }

    /**
     * @param string $SalesType
     * @return $this
     */
    public function setSalesType($SalesType)
    {
        $this->SalesType = $SalesType;
        return $this;
    }

    /**
     * @return string
     */
    public function getSalesType()
    {
        return $this->SalesType;
    }

    /**
     * @param string $ShipToCountryCode
     * @return $this
     */
    public function setShipToCountryCode($ShipToCountryCode)
    {
        $this->ShipToCountryCode = $ShipToCountryCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getShipToCountryCode()
    {
        return $this->ShipToCountryCode;
    }

    /**
     * @param float $ShippingAmount
     * @return $this
     */
    public function setShippingAmount($ShippingAmount)
    {
        $this->ShippingAmount = $ShippingAmount;
        return $this;
    }

    /**
     * @return float
     */
    public function getShippingAmount()
    {
        return $this->ShippingAmount;
    }

    /**
     * @param string $StoreId
     * @return $this
     */
    public function setStoreId($StoreId)
    {
        $this->StoreId = $StoreId;
        return $this;
    }

    /**
     * @return string
     */
    public function getStoreId()
    {
        return $this->StoreId;
    }

    /**
     * @param float $TotalAmount
     * @return $this
     */
    public function setTotalAmount($TotalAmount)
    {
        $this->TotalAmount = $TotalAmount;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->TotalAmount;
    }

    /**
     * @param float $TotalDiscAmount
     * @return $this
     */
    public function setTotalDiscAmount($TotalDiscAmount)
    {
        $this->TotalDiscAmount = $TotalDiscAmount;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotalDiscAmount()
    {
        return $this->TotalDiscAmount;
    }

    /**
     * @param float $TotalNetAmount
     * @return $this
     */
    public function setTotalNetAmount($TotalNetAmount)
    {
        $this->TotalNetAmount = $TotalNetAmount;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotalNetAmount()
    {
        return $this->TotalNetAmount;
    }

    /**
     * @param float $TotalTaxAmount
     * @return $this
     */
    public function setTotalTaxAmount($TotalTaxAmount)
    {
        $this->TotalTaxAmount = $TotalTaxAmount;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotalTaxAmount()
    {
        return $this->TotalTaxAmount;
    }


}

