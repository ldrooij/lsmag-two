<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use IteratorAggregate;
use ArrayIterator;

class ArrayOfReplCurrency implements IteratorAggregate
{
    /**
     * @property ReplCurrency[] $ReplCurrency
     */
    protected $ReplCurrency = [
        
    ];

    /**
     * @param ReplCurrency[] $ReplCurrency
     * @return $this
     */
    public function setReplCurrency($ReplCurrency)
    {
        $this->ReplCurrency = $ReplCurrency;
        return $this;
    }

    /**
     * @return ReplCurrency[]
     */
    public function getIterator() : \Traversable
    {
        return new ArrayIterator( $this->ReplCurrency );
    }

    /**
     * @return ReplCurrency[]
     */
    public function getReplCurrency()
    {
        return $this->ReplCurrency;
    }
}

