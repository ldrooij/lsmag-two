<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use IteratorAggregate;
use ArrayIterator;

class ArrayOfReplAttributeValue implements IteratorAggregate
{
    /**
     * @property ReplAttributeValue[] $ReplAttributeValue
     */
    protected $ReplAttributeValue = [
        
    ];

    /**
     * @param ReplAttributeValue[] $ReplAttributeValue
     * @return $this
     */
    public function setReplAttributeValue($ReplAttributeValue)
    {
        $this->ReplAttributeValue = $ReplAttributeValue;
        return $this;
    }

    /**
     * @return ReplAttributeValue[]
     */
    public function getIterator() : \Traversable
    {
        return new ArrayIterator( $this->ReplAttributeValue );
    }

    /**
     * @return ReplAttributeValue[]
     */
    public function getReplAttributeValue()
    {
        return $this->ReplAttributeValue;
    }
}

