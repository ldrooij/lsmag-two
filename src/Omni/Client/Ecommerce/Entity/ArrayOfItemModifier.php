<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use IteratorAggregate;
use ArrayIterator;

class ArrayOfItemModifier implements IteratorAggregate
{
    /**
     * @property ItemModifier[] $ItemModifier
     */
    protected $ItemModifier = [
        
    ];

    /**
     * @param ItemModifier[] $ItemModifier
     * @return $this
     */
    public function setItemModifier($ItemModifier)
    {
        $this->ItemModifier = $ItemModifier;
        return $this;
    }

    /**
     * @return ItemModifier[]
     */
    public function getIterator() : \Traversable
    {
        return new ArrayIterator( $this->ItemModifier );
    }

    /**
     * @return ItemModifier[]
     */
    public function getItemModifier()
    {
        return $this->ItemModifier;
    }
}

