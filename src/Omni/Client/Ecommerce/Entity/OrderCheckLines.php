<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

class OrderCheckLines
{
    /**
     * @property float $Amount
     */
    protected $Amount = null;

    /**
     * @property string $DocumentID
     */
    protected $DocumentID = null;

    /**
     * @property string $ItemDescription
     */
    protected $ItemDescription = null;

    /**
     * @property string $ItemId
     */
    protected $ItemId = null;

    /**
     * @property int $LineNo
     */
    protected $LineNo = null;

    /**
     * @property float $Quantity
     */
    protected $Quantity = null;

    /**
     * @property string $UOMDescription
     */
    protected $UOMDescription = null;

    /**
     * @property string $UnitofMeasureCode
     */
    protected $UnitofMeasureCode = null;

    /**
     * @property string $VariantCode
     */
    protected $VariantCode = null;

    /**
     * @property string $VariantDescription
     */
    protected $VariantDescription = null;

    /**
     * @param float $Amount
     * @return $this
     */
    public function setAmount($Amount)
    {
        $this->Amount = $Amount;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->Amount;
    }

    /**
     * @param string $DocumentID
     * @return $this
     */
    public function setDocumentID($DocumentID)
    {
        $this->DocumentID = $DocumentID;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentID()
    {
        return $this->DocumentID;
    }

    /**
     * @param string $ItemDescription
     * @return $this
     */
    public function setItemDescription($ItemDescription)
    {
        $this->ItemDescription = $ItemDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getItemDescription()
    {
        return $this->ItemDescription;
    }

    /**
     * @param string $ItemId
     * @return $this
     */
    public function setItemId($ItemId)
    {
        $this->ItemId = $ItemId;
        return $this;
    }

    /**
     * @return string
     */
    public function getItemId()
    {
        return $this->ItemId;
    }

    /**
     * @param int $LineNo
     * @return $this
     */
    public function setLineNo($LineNo)
    {
        $this->LineNo = $LineNo;
        return $this;
    }

    /**
     * @return int
     */
    public function getLineNo()
    {
        return $this->LineNo;
    }

    /**
     * @param float $Quantity
     * @return $this
     */
    public function setQuantity($Quantity)
    {
        $this->Quantity = $Quantity;
        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity()
    {
        return $this->Quantity;
    }

    /**
     * @param string $UOMDescription
     * @return $this
     */
    public function setUOMDescription($UOMDescription)
    {
        $this->UOMDescription = $UOMDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getUOMDescription()
    {
        return $this->UOMDescription;
    }

    /**
     * @param string $UnitofMeasureCode
     * @return $this
     */
    public function setUnitofMeasureCode($UnitofMeasureCode)
    {
        $this->UnitofMeasureCode = $UnitofMeasureCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnitofMeasureCode()
    {
        return $this->UnitofMeasureCode;
    }

    /**
     * @param string $VariantCode
     * @return $this
     */
    public function setVariantCode($VariantCode)
    {
        $this->VariantCode = $VariantCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getVariantCode()
    {
        return $this->VariantCode;
    }

    /**
     * @param string $VariantDescription
     * @return $this
     */
    public function setVariantDescription($VariantDescription)
    {
        $this->VariantDescription = $VariantDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getVariantDescription()
    {
        return $this->VariantDescription;
    }
}

