<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 */


namespace Ls\Omni\Client\Ecommerce\Entity;

use Ls\Omni\Client\ResponseInterface;

class ReplEcommDataTranslationResponse implements ResponseInterface
{

    /**
     * @property ReplDataTranslationResponse $ReplEcommDataTranslationResult
     */
    protected $ReplEcommDataTranslationResult = null;

    /**
     * @param ReplDataTranslationResponse $ReplEcommDataTranslationResult
     * @return $this
     */
    public function setReplEcommDataTranslationResult($ReplEcommDataTranslationResult)
    {
        $this->ReplEcommDataTranslationResult = $ReplEcommDataTranslationResult;
        return $this;
    }

    /**
     * @return ReplDataTranslationResponse
     */
    public function getReplEcommDataTranslationResult()
    {
        return $this->ReplEcommDataTranslationResult;
    }

    /**
     * @return ReplDataTranslationResponse
     */
    public function getResult()
    {
        return $this->ReplEcommDataTranslationResult;
    }


}

