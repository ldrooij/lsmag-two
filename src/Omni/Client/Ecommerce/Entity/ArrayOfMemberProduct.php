<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use IteratorAggregate;
use ArrayIterator;

class ArrayOfMemberProduct implements IteratorAggregate
{
    /**
     * @property MemberProduct[] $MemberProduct
     */
    protected $MemberProduct = [
        
    ];

    /**
     * @param MemberProduct[] $MemberProduct
     * @return $this
     */
    public function setMemberProduct($MemberProduct)
    {
        $this->MemberProduct = $MemberProduct;
        return $this;
    }

    /**
     * @return MemberProduct[]
     */
    public function getIterator() : \Traversable
    {
        return new ArrayIterator( $this->MemberProduct );
    }

    /**
     * @return MemberProduct[]
     */
    public function getMemberProduct()
    {
        return $this->MemberProduct;
    }
}

