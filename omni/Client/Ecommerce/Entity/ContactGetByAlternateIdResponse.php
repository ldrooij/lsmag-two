<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use Ls\Omni\Client\ResponseInterface;

class ContactGetByAlternateIdResponse implements ResponseInterface
{

    /**
     * @property Contact $ContactGetByAlternateIdResult
     */
    protected $ContactGetByAlternateIdResult = null;

    /**
     * @param Contact $ContactGetByAlternateIdResult
     * @return $this
     */
    public function setContactGetByAlternateIdResult($ContactGetByAlternateIdResult)
    {
        $this->ContactGetByAlternateIdResult = $ContactGetByAlternateIdResult;
        return $this;
    }

    /**
     * @return Contact
     */
    public function getContactGetByAlternateIdResult()
    {
        return $this->ContactGetByAlternateIdResult;
    }

    /**
     * @return Contact
     */
    public function getResult()
    {
        return $this->ContactGetByAlternateIdResult;
    }


}

