<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use IteratorAggregate;
use ArrayIterator;

class ArrayOfOrderPayment implements IteratorAggregate
{
    /**
     * @property OrderPayment[] $OrderPayment
     */
    protected $OrderPayment = [
        
    ];

    /**
     * @param OrderPayment[] $OrderPayment
     * @return $this
     */
    public function setOrderPayment($OrderPayment)
    {
        $this->OrderPayment = $OrderPayment;
        return $this;
    }

    /**
     * @return OrderPayment[]
     */
    public function getIterator() : \Traversable
    {
        return new ArrayIterator( $this->OrderPayment );
    }

    /**
     * @return OrderPayment[]
     */
    public function getOrderPayment()
    {
        return $this->OrderPayment;
    }
}

