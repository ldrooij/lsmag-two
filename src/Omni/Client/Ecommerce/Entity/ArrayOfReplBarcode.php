<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use IteratorAggregate;
use ArrayIterator;

class ArrayOfReplBarcode implements IteratorAggregate
{
    /**
     * @property ReplBarcode[] $ReplBarcode
     */
    protected $ReplBarcode = [
        
    ];

    /**
     * @param ReplBarcode[] $ReplBarcode
     * @return $this
     */
    public function setReplBarcode($ReplBarcode)
    {
        $this->ReplBarcode = $ReplBarcode;
        return $this;
    }

    /**
     * @return ReplBarcode[]
     */
    public function getIterator() : \Traversable
    {
        return new ArrayIterator( $this->ReplBarcode );
    }

    /**
     * @return ReplBarcode[]
     */
    public function getReplBarcode()
    {
        return $this->ReplBarcode;
    }
}

