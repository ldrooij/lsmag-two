<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use Ls\Omni\Client\ResponseInterface;

class ReplEcommVendorItemMappingResponse implements ResponseInterface
{

    /**
     * @property ReplVendorItemMappingResponse $ReplEcommVendorItemMappingResult
     */
    protected $ReplEcommVendorItemMappingResult = null;

    /**
     * @param ReplVendorItemMappingResponse $ReplEcommVendorItemMappingResult
     * @return $this
     */
    public function setReplEcommVendorItemMappingResult($ReplEcommVendorItemMappingResult)
    {
        $this->ReplEcommVendorItemMappingResult = $ReplEcommVendorItemMappingResult;
        return $this;
    }

    /**
     * @return ReplVendorItemMappingResponse
     */
    public function getReplEcommVendorItemMappingResult()
    {
        return $this->ReplEcommVendorItemMappingResult;
    }

    /**
     * @return ReplVendorItemMappingResponse
     */
    public function getResult()
    {
        return $this->ReplEcommVendorItemMappingResult;
    }


}

