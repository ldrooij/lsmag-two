<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use Ls\Omni\Client\ResponseInterface;

class LoginWebResponse implements ResponseInterface
{

    /**
     * @property Contact $LoginWebResult
     */
    protected $LoginWebResult = null;

    /**
     * @param Contact $LoginWebResult
     * @return $this
     */
    public function setLoginWebResult($LoginWebResult)
    {
        $this->LoginWebResult = $LoginWebResult;
        return $this;
    }

    /**
     * @return Contact
     */
    public function getLoginWebResult()
    {
        return $this->LoginWebResult;
    }

    /**
     * @return Contact
     */
    public function getResult()
    {
        return $this->LoginWebResult;
    }


}

