<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use Ls\Omni\Client\ResponseInterface;

class EnvironmentResponse implements ResponseInterface
{

    /**
     * @property Environment $EnvironmentResult
     */
    protected $EnvironmentResult = null;

    /**
     * @param Environment $EnvironmentResult
     * @return $this
     */
    public function setEnvironmentResult($EnvironmentResult)
    {
        $this->EnvironmentResult = $EnvironmentResult;
        return $this;
    }

    /**
     * @return Environment
     */
    public function getEnvironmentResult()
    {
        return $this->EnvironmentResult;
    }

    /**
     * @return Environment
     */
    public function getResult()
    {
        return $this->EnvironmentResult;
    }


}

