<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 */


namespace Ls\Omni\Client\Loyalty\Entity;

use Ls\Omni\Client\ResponseInterface;

class ContactUpdateResponse implements ResponseInterface
{

    /**
     * @property Contact $ContactUpdateResult
     */
    protected $ContactUpdateResult = null;

    /**
     * @param Contact $ContactUpdateResult
     * @return $this
     */
    public function setContactUpdateResult($ContactUpdateResult)
    {
        $this->ContactUpdateResult = $ContactUpdateResult;
        return $this;
    }

    /**
     * @return Contact
     */
    public function getContactUpdateResult()
    {
        return $this->ContactUpdateResult;
    }

    /**
     * @return Contact
     */
    public function getResult()
    {
        return $this->ContactUpdateResult;
    }


}

