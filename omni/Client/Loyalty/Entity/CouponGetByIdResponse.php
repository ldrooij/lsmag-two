<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 */


namespace Ls\Omni\Client\Loyalty\Entity;

use Ls\Omni\Client\ResponseInterface;

class CouponGetByIdResponse implements ResponseInterface
{

    /**
     * @property Coupon $CouponGetByIdResult
     */
    protected $CouponGetByIdResult = null;

    /**
     * @param Coupon $CouponGetByIdResult
     * @return $this
     */
    public function setCouponGetByIdResult($CouponGetByIdResult)
    {
        $this->CouponGetByIdResult = $CouponGetByIdResult;
        return $this;
    }

    /**
     * @return Coupon
     */
    public function getCouponGetByIdResult()
    {
        return $this->CouponGetByIdResult;
    }

    /**
     * @return Coupon
     */
    public function getResult()
    {
        return $this->CouponGetByIdResult;
    }


}

