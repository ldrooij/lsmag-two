<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use IteratorAggregate;
use ArrayIterator;

class ArrayOfSalesEntryDiscountLine implements IteratorAggregate
{
    /**
     * @property SalesEntryDiscountLine[] $SalesEntryDiscountLine
     */
    protected $SalesEntryDiscountLine = [
        
    ];

    /**
     * @param SalesEntryDiscountLine[] $SalesEntryDiscountLine
     * @return $this
     */
    public function setSalesEntryDiscountLine($SalesEntryDiscountLine)
    {
        $this->SalesEntryDiscountLine = $SalesEntryDiscountLine;
        return $this;
    }

    /**
     * @return SalesEntryDiscountLine[]
     */
    public function getIterator() : \Traversable
    {
        return new ArrayIterator( $this->SalesEntryDiscountLine );
    }

    /**
     * @return SalesEntryDiscountLine[]
     */
    public function getSalesEntryDiscountLine()
    {
        return $this->SalesEntryDiscountLine;
    }
}

