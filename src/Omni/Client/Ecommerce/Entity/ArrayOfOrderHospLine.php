<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use IteratorAggregate;
use ArrayIterator;

class ArrayOfOrderHospLine implements IteratorAggregate
{
    /**
     * @property OrderHospLine[] $OrderHospLine
     */
    protected $OrderHospLine = [
        
    ];

    /**
     * @param OrderHospLine[] $OrderHospLine
     * @return $this
     */
    public function setOrderHospLine($OrderHospLine)
    {
        $this->OrderHospLine = $OrderHospLine;
        return $this;
    }

    /**
     * @return OrderHospLine[]
     */
    public function getIterator() : \Traversable
    {
        return new ArrayIterator( $this->OrderHospLine );
    }

    /**
     * @return OrderHospLine[]
     */
    public function getOrderHospLine()
    {
        return $this->OrderHospLine;
    }
}

