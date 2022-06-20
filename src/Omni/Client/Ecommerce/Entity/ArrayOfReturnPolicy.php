<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use IteratorAggregate;
use ArrayIterator;

class ArrayOfReturnPolicy implements IteratorAggregate
{
    /**
     * @property ReturnPolicy[] $ReturnPolicy
     */
    protected $ReturnPolicy = [
        
    ];

    /**
     * @param ReturnPolicy[] $ReturnPolicy
     * @return $this
     */
    public function setReturnPolicy($ReturnPolicy)
    {
        $this->ReturnPolicy = $ReturnPolicy;
        return $this;
    }

    /**
     * @return ReturnPolicy[]
     */
    public function getIterator() : \Traversable
    {
        return new ArrayIterator( $this->ReturnPolicy );
    }

    /**
     * @return ReturnPolicy[]
     */
    public function getReturnPolicy()
    {
        return $this->ReturnPolicy;
    }
}

