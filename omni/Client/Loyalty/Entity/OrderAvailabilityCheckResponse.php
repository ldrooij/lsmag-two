<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 */


namespace Ls\Omni\Client\Loyalty\Entity;

use Ls\Omni\Client\ResponseInterface;

class OrderAvailabilityCheckResponse implements ResponseInterface
{

    /**
     * @property ArrayOfOrderLineAvailability $OrderAvailabilityCheckResult
     */
    protected $OrderAvailabilityCheckResult = null;

    /**
     * @param ArrayOfOrderLineAvailability $OrderAvailabilityCheckResult
     * @return $this
     */
    public function setOrderAvailabilityCheckResult($OrderAvailabilityCheckResult)
    {
        $this->OrderAvailabilityCheckResult = $OrderAvailabilityCheckResult;
        return $this;
    }

    /**
     * @return ArrayOfOrderLineAvailability
     */
    public function getOrderAvailabilityCheckResult()
    {
        return $this->OrderAvailabilityCheckResult;
    }

    /**
     * @return ArrayOfOrderLineAvailability
     */
    public function getResult()
    {
        return $this->OrderAvailabilityCheckResult;
    }


}

