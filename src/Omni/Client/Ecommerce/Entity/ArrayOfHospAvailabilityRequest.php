<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use IteratorAggregate;
use ArrayIterator;

class ArrayOfHospAvailabilityRequest implements IteratorAggregate
{
    /**
     * @property HospAvailabilityRequest[] $HospAvailabilityRequest
     */
    protected $HospAvailabilityRequest = [
        
    ];

    /**
     * @param HospAvailabilityRequest[] $HospAvailabilityRequest
     * @return $this
     */
    public function setHospAvailabilityRequest($HospAvailabilityRequest)
    {
        $this->HospAvailabilityRequest = $HospAvailabilityRequest;
        return $this;
    }

    /**
     * @return HospAvailabilityRequest[]
     */
    public function getIterator() : \Traversable
    {
        return new ArrayIterator( $this->HospAvailabilityRequest );
    }

    /**
     * @return HospAvailabilityRequest[]
     */
    public function getHospAvailabilityRequest()
    {
        return $this->HospAvailabilityRequest;
    }
}

