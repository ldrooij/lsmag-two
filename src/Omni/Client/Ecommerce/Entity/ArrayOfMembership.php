<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use IteratorAggregate;
use ArrayIterator;

class ArrayOfMembership implements IteratorAggregate
{
    /**
     * @property Membership[] $Membership
     */
    protected $Membership = [
        
    ];

    /**
     * @param Membership[] $Membership
     * @return $this
     */
    public function setMembership($Membership)
    {
        $this->Membership = $Membership;
        return $this;
    }

    /**
     * @return Membership[]
     */
    public function getIterator() : \Traversable
    {
        return new ArrayIterator( $this->Membership );
    }

    /**
     * @return Membership[]
     */
    public function getMembership()
    {
        return $this->Membership;
    }
}

