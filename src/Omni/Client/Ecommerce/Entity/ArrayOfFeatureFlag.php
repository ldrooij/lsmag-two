<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use IteratorAggregate;
use ArrayIterator;

class ArrayOfFeatureFlag implements IteratorAggregate
{
    /**
     * @property FeatureFlag[] $FeatureFlag
     */
    protected $FeatureFlag = [
        
    ];

    /**
     * @param FeatureFlag[] $FeatureFlag
     * @return $this
     */
    public function setFeatureFlag($FeatureFlag)
    {
        $this->FeatureFlag = $FeatureFlag;
        return $this;
    }

    /**
     * @return FeatureFlag[]
     */
    public function getIterator() : \Traversable
    {
        return new ArrayIterator( $this->FeatureFlag );
    }

    /**
     * @return FeatureFlag[]
     */
    public function getFeatureFlag()
    {
        return $this->FeatureFlag;
    }
}

