<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 * @codingStandardsIgnoreFile
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use Ls\Omni\Client\ResponseInterface;

class ConatctBlockResponse implements ResponseInterface
{
    /**
     * @property boolean $ConatctBlockResult
     */
    protected $ConatctBlockResult = null;

    /**
     * @param boolean $ConatctBlockResult
     * @return $this
     */
    public function setConatctBlockResult($ConatctBlockResult)
    {
        $this->ConatctBlockResult = $ConatctBlockResult;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getConatctBlockResult()
    {
        return $this->ConatctBlockResult;
    }

    /**
     * @return boolean
     */
    public function getResult()
    {
        return $this->ConatctBlockResult;
    }
}

