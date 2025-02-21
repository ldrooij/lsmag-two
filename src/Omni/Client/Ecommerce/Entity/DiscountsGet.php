<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use Ls\Omni\Client\RequestInterface;

class DiscountsGet implements RequestInterface
{
    /**
     * @property ArrayOfstring $itemiIds
     */
    protected $itemiIds = null;

    /**
     * @property string $storeId
     */
    protected $storeId = null;

    /**
     * @property string $loyaltySchemeCode
     */
    protected $loyaltySchemeCode = null;

    /**
     * @param ArrayOfstring $itemiIds
     * @return $this
     */
    public function setItemiIds($itemiIds)
    {
        $this->itemiIds = $itemiIds;
        return $this;
    }

    /**
     * @return ArrayOfstring
     */
    public function getItemiIds()
    {
        return $this->itemiIds;
    }

    /**
     * @param string $storeId
     * @return $this
     */
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
        return $this;
    }

    /**
     * @return string
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * @param string $loyaltySchemeCode
     * @return $this
     */
    public function setLoyaltySchemeCode($loyaltySchemeCode)
    {
        $this->loyaltySchemeCode = $loyaltySchemeCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getLoyaltySchemeCode()
    {
        return $this->loyaltySchemeCode;
    }
}

