<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use IteratorAggregate;
use ArrayIterator;

class ArrayOfOneList implements IteratorAggregate
{
    /**
     * @property OneList[] $OneList
     */
    protected $OneList = [
        
    ];

    /**
     * @param OneList[] $OneList
     * @return $this
     */
    public function setOneList($OneList)
    {
        $this->OneList = $OneList;
        return $this;
    }

    /**
     * @return OneList[]
     */
    public function getIterator() : \Traversable
    {
        return new ArrayIterator( $this->OneList );
    }

    /**
     * @return OneList[]
     */
    public function getOneList()
    {
        return $this->OneList;
    }
}

