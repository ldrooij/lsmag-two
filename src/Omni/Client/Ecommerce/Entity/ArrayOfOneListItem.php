<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use IteratorAggregate;
use ArrayIterator;

class ArrayOfOneListItem implements IteratorAggregate
{
    /**
     * @property OneListItem[] $OneListItem
     */
    protected $OneListItem = [
        
    ];

    /**
     * @param OneListItem[] $OneListItem
     * @return $this
     */
    public function setOneListItem($OneListItem)
    {
        $this->OneListItem = $OneListItem;
        return $this;
    }

    /**
     * @return OneListItem[]
     */
    public function getIterator() : \Traversable
    {
        return new ArrayIterator( $this->OneListItem );
    }

    /**
     * @return OneListItem[]
     */
    public function getOneListItem()
    {
        return $this->OneListItem;
    }
}

