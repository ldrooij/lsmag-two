<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use Ls\Omni\Client\Ecommerce\Entity\Enum\DocumentIdType;
use Ls\Omni\Client\Ecommerce\Entity\Enum\ShippingStatus;
use Ls\Omni\Client\Ecommerce\Entity\Enum\SalesEntryStatus;
use Ls\Omni\Exception\InvalidEnumException;

class SalesEntry extends Entity
{

    /**
     * @property ArrayOfSalesEntryDiscountLine $DiscountLines
     */
    protected $DiscountLines = null;

    /**
     * @property ArrayOfSalesEntryLine $Lines
     */
    protected $Lines = null;

    /**
     * @property ArrayOfSalesEntryPayment $Payments
     */
    protected $Payments = null;

    /**
     * @property boolean $AnonymousOrder
     */
    protected $AnonymousOrder = null;

    /**
     * @property string $CardId
     */
    protected $CardId = null;

    /**
     * @property boolean $ClickAndCollectOrder
     */
    protected $ClickAndCollectOrder = null;

    /**
     * @property Address $ContactAddress
     */
    protected $ContactAddress = null;

    /**
     * @property string $ContactDayTimePhoneNo
     */
    protected $ContactDayTimePhoneNo = null;

    /**
     * @property string $ContactEmail
     */
    protected $ContactEmail = null;

    /**
     * @property string $ContactName
     */
    protected $ContactName = null;

    /**
     * @property string $CustomerId
     */
    protected $CustomerId = null;

    /**
     * @property string $CustomerOrderNo
     */
    protected $CustomerOrderNo = null;

    /**
     * @property string $DocumentRegTime
     */
    protected $DocumentRegTime = null;

    /**
     * @property string $ExternalId
     */
    protected $ExternalId = null;

    /**
     * @property DocumentIdType $IdType
     */
    protected $IdType = null;

    /**
     * @property int $LineItemCount
     */
    protected $LineItemCount = null;

    /**
     * @property float $PointsRewarded
     */
    protected $PointsRewarded = null;

    /**
     * @property float $PointsUsedInOrder
     */
    protected $PointsUsedInOrder = null;

    /**
     * @property boolean $Posted
     */
    protected $Posted = null;

    /**
     * @property string $RequestedDeliveryDate
     */
    protected $RequestedDeliveryDate = null;

    /**
     * @property Address $ShipToAddress
     */
    protected $ShipToAddress = null;

    /**
     * @property string $ShipToEmail
     */
    protected $ShipToEmail = null;

    /**
     * @property string $ShipToName
     */
    protected $ShipToName = null;

    /**
     * @property string $ShippingAgentCode
     */
    protected $ShippingAgentCode = null;

    /**
     * @property string $ShippingAgentServiceCode
     */
    protected $ShippingAgentServiceCode = null;

    /**
     * @property ShippingStatus $ShippingStatus
     */
    protected $ShippingStatus = null;

    /**
     * @property SalesEntryStatus $Status
     */
    protected $Status = null;

    /**
     * @property string $StoreId
     */
    protected $StoreId = null;

    /**
     * @property string $StoreName
     */
    protected $StoreName = null;

    /**
     * @property string $TerminalId
     */
    protected $TerminalId = null;

    /**
     * @property float $TotalAmount
     */
    protected $TotalAmount = null;

    /**
     * @property float $TotalDiscount
     */
    protected $TotalDiscount = null;

    /**
     * @property float $TotalNetAmount
     */
    protected $TotalNetAmount = null;

    /**
     * @param ArrayOfSalesEntryDiscountLine $DiscountLines
     * @return $this
     */
    public function setDiscountLines($DiscountLines)
    {
        $this->DiscountLines = $DiscountLines;
        return $this;
    }

    /**
     * @return ArrayOfSalesEntryDiscountLine
     */
    public function getDiscountLines()
    {
        return $this->DiscountLines;
    }

    /**
     * @param ArrayOfSalesEntryLine $Lines
     * @return $this
     */
    public function setLines($Lines)
    {
        $this->Lines = $Lines;
        return $this;
    }

    /**
     * @return ArrayOfSalesEntryLine
     */
    public function getLines()
    {
        return $this->Lines;
    }

    /**
     * @param ArrayOfSalesEntryPayment $Payments
     * @return $this
     */
    public function setPayments($Payments)
    {
        $this->Payments = $Payments;
        return $this;
    }

    /**
     * @return ArrayOfSalesEntryPayment
     */
    public function getPayments()
    {
        return $this->Payments;
    }

    /**
     * @param boolean $AnonymousOrder
     * @return $this
     */
    public function setAnonymousOrder($AnonymousOrder)
    {
        $this->AnonymousOrder = $AnonymousOrder;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getAnonymousOrder()
    {
        return $this->AnonymousOrder;
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
     * @param boolean $ClickAndCollectOrder
     * @return $this
     */
    public function setClickAndCollectOrder($ClickAndCollectOrder)
    {
        $this->ClickAndCollectOrder = $ClickAndCollectOrder;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getClickAndCollectOrder()
    {
        return $this->ClickAndCollectOrder;
    }

    /**
     * @param Address $ContactAddress
     * @return $this
     */
    public function setContactAddress($ContactAddress)
    {
        $this->ContactAddress = $ContactAddress;
        return $this;
    }

    /**
     * @return Address
     */
    public function getContactAddress()
    {
        return $this->ContactAddress;
    }

    /**
     * @param string $ContactDayTimePhoneNo
     * @return $this
     */
    public function setContactDayTimePhoneNo($ContactDayTimePhoneNo)
    {
        $this->ContactDayTimePhoneNo = $ContactDayTimePhoneNo;
        return $this;
    }

    /**
     * @return string
     */
    public function getContactDayTimePhoneNo()
    {
        return $this->ContactDayTimePhoneNo;
    }

    /**
     * @param string $ContactEmail
     * @return $this
     */
    public function setContactEmail($ContactEmail)
    {
        $this->ContactEmail = $ContactEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getContactEmail()
    {
        return $this->ContactEmail;
    }

    /**
     * @param string $ContactName
     * @return $this
     */
    public function setContactName($ContactName)
    {
        $this->ContactName = $ContactName;
        return $this;
    }

    /**
     * @return string
     */
    public function getContactName()
    {
        return $this->ContactName;
    }

    /**
     * @param string $CustomerId
     * @return $this
     */
    public function setCustomerId($CustomerId)
    {
        $this->CustomerId = $CustomerId;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerId()
    {
        return $this->CustomerId;
    }

    /**
     * @param string $CustomerOrderNo
     * @return $this
     */
    public function setCustomerOrderNo($CustomerOrderNo)
    {
        $this->CustomerOrderNo = $CustomerOrderNo;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerOrderNo()
    {
        return $this->CustomerOrderNo;
    }

    /**
     * @param string $DocumentRegTime
     * @return $this
     */
    public function setDocumentRegTime($DocumentRegTime)
    {
        $this->DocumentRegTime = $DocumentRegTime;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentRegTime()
    {
        return $this->DocumentRegTime;
    }

    /**
     * @param string $ExternalId
     * @return $this
     */
    public function setExternalId($ExternalId)
    {
        $this->ExternalId = $ExternalId;
        return $this;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->ExternalId;
    }

    /**
     * @param DocumentIdType|string $IdType
     * @return $this
     * @throws InvalidEnumException
     */
    public function setIdType($IdType)
    {
        if ( ! $IdType instanceof DocumentIdType ) {
            if ( DocumentIdType::isValid( $IdType ) )
                $IdType = new DocumentIdType( $IdType );
            elseif ( DocumentIdType::isValidKey( $IdType ) )
                $IdType = new DocumentIdType( constant( "DocumentIdType::$IdType" ) );
            elseif ( ! $IdType instanceof DocumentIdType )
                throw new InvalidEnumException();
        }
        $this->IdType = $IdType->getValue();

        return $this;
    }

    /**
     * @return DocumentIdType
     */
    public function getIdType()
    {
        return $this->IdType;
    }

    /**
     * @param int $LineItemCount
     * @return $this
     */
    public function setLineItemCount($LineItemCount)
    {
        $this->LineItemCount = $LineItemCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getLineItemCount()
    {
        return $this->LineItemCount;
    }

    /**
     * @param float $PointsRewarded
     * @return $this
     */
    public function setPointsRewarded($PointsRewarded)
    {
        $this->PointsRewarded = $PointsRewarded;
        return $this;
    }

    /**
     * @return float
     */
    public function getPointsRewarded()
    {
        return $this->PointsRewarded;
    }

    /**
     * @param float $PointsUsedInOrder
     * @return $this
     */
    public function setPointsUsedInOrder($PointsUsedInOrder)
    {
        $this->PointsUsedInOrder = $PointsUsedInOrder;
        return $this;
    }

    /**
     * @return float
     */
    public function getPointsUsedInOrder()
    {
        return $this->PointsUsedInOrder;
    }

    /**
     * @param boolean $Posted
     * @return $this
     */
    public function setPosted($Posted)
    {
        $this->Posted = $Posted;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getPosted()
    {
        return $this->Posted;
    }

    /**
     * @param string $RequestedDeliveryDate
     * @return $this
     */
    public function setRequestedDeliveryDate($RequestedDeliveryDate)
    {
        $this->RequestedDeliveryDate = $RequestedDeliveryDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getRequestedDeliveryDate()
    {
        return $this->RequestedDeliveryDate;
    }

    /**
     * @param Address $ShipToAddress
     * @return $this
     */
    public function setShipToAddress($ShipToAddress)
    {
        $this->ShipToAddress = $ShipToAddress;
        return $this;
    }

    /**
     * @return Address
     */
    public function getShipToAddress()
    {
        return $this->ShipToAddress;
    }

    /**
     * @param string $ShipToEmail
     * @return $this
     */
    public function setShipToEmail($ShipToEmail)
    {
        $this->ShipToEmail = $ShipToEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getShipToEmail()
    {
        return $this->ShipToEmail;
    }

    /**
     * @param string $ShipToName
     * @return $this
     */
    public function setShipToName($ShipToName)
    {
        $this->ShipToName = $ShipToName;
        return $this;
    }

    /**
     * @return string
     */
    public function getShipToName()
    {
        return $this->ShipToName;
    }

    /**
     * @param string $ShippingAgentCode
     * @return $this
     */
    public function setShippingAgentCode($ShippingAgentCode)
    {
        $this->ShippingAgentCode = $ShippingAgentCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getShippingAgentCode()
    {
        return $this->ShippingAgentCode;
    }

    /**
     * @param string $ShippingAgentServiceCode
     * @return $this
     */
    public function setShippingAgentServiceCode($ShippingAgentServiceCode)
    {
        $this->ShippingAgentServiceCode = $ShippingAgentServiceCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getShippingAgentServiceCode()
    {
        return $this->ShippingAgentServiceCode;
    }

    /**
     * @param ShippingStatus|string $ShippingStatus
     * @return $this
     * @throws InvalidEnumException
     */
    public function setShippingStatus($ShippingStatus)
    {
        if ( ! $ShippingStatus instanceof ShippingStatus ) {
            if ( ShippingStatus::isValid( $ShippingStatus ) )
                $ShippingStatus = new ShippingStatus( $ShippingStatus );
            elseif ( ShippingStatus::isValidKey( $ShippingStatus ) )
                $ShippingStatus = new ShippingStatus( constant( "ShippingStatus::$ShippingStatus" ) );
            elseif ( ! $ShippingStatus instanceof ShippingStatus )
                throw new InvalidEnumException();
        }
        $this->ShippingStatus = $ShippingStatus->getValue();

        return $this;
    }

    /**
     * @return ShippingStatus
     */
    public function getShippingStatus()
    {
        return $this->ShippingStatus;
    }

    /**
     * @param SalesEntryStatus|string $Status
     * @return $this
     * @throws InvalidEnumException
     */
    public function setStatus($Status)
    {
        if ( ! $Status instanceof SalesEntryStatus ) {
            if ( SalesEntryStatus::isValid( $Status ) )
                $Status = new SalesEntryStatus( $Status );
            elseif ( SalesEntryStatus::isValidKey( $Status ) )
                $Status = new SalesEntryStatus( constant( "SalesEntryStatus::$Status" ) );
            elseif ( ! $Status instanceof SalesEntryStatus )
                throw new InvalidEnumException();
        }
        $this->Status = $Status->getValue();

        return $this;
    }

    /**
     * @return SalesEntryStatus
     */
    public function getStatus()
    {
        return $this->Status;
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
     * @param string $StoreName
     * @return $this
     */
    public function setStoreName($StoreName)
    {
        $this->StoreName = $StoreName;
        return $this;
    }

    /**
     * @return string
     */
    public function getStoreName()
    {
        return $this->StoreName;
    }

    /**
     * @param string $TerminalId
     * @return $this
     */
    public function setTerminalId($TerminalId)
    {
        $this->TerminalId = $TerminalId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTerminalId()
    {
        return $this->TerminalId;
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
     * @param float $TotalDiscount
     * @return $this
     */
    public function setTotalDiscount($TotalDiscount)
    {
        $this->TotalDiscount = $TotalDiscount;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotalDiscount()
    {
        return $this->TotalDiscount;
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


}

