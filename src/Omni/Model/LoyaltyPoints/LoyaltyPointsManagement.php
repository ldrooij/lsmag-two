<?php

namespace Ls\Omni\Model\LoyaltyPoints;

use \Ls\Omni\Helper\LoyaltyHelper;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\Quote;
use Magento\Directory\Model\Currency;

/**
 * LoyaltyPointsManagement class to handle Loyalty points
 */
class LoyaltyPointsManagement
{
    /**
     * Sales quote repository
     *
     * @var CartRepositoryInterface
     */
    public $quoteRepository;

    /**
     * @var LoyaltyHelper
     */
    public $loyaltyHelper;

    /**
     * @var Currency
     */
    public $currencyHelper;

    /**
     * LoyaltyPointsManagement constructor.
     * @param CartRepositoryInterface $quoteRepository
     * @param LoyaltyHelper $loyaltyHelper
     * @param Currency $currencyHelper
     */
    public function __construct(
        CartRepositoryInterface $quoteRepository,
        LoyaltyHelper $loyaltyHelper,
        Currency $currencyHelper
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->loyaltyHelper   = $loyaltyHelper;
        $this->currencyHelper  = $currencyHelper;
    }

    /**
     * Get the loyalty points info from quote
     * @param $cartId
     * @return array
     * @throws NoSuchEntityException
     */
    public function get($cartId)
    {
        /** @var  Quote $quote */
        $quote         = $this->quoteRepository->getActive($cartId);
        $lsPointsSpent = $quote->getLsPointsSpent();
        $lsPointsEarn  = $quote->getLsPointsEarn();
        $pointDiscount = 0;
        $pointRate     = $this->loyaltyHelper->getPointRate();
        if ($lsPointsSpent > 0) {
            $pointDiscount = -$lsPointsSpent * $pointRate;
        }
        return $lsPointsArray = [
            'points_earn'     => $lsPointsEarn,
            'points_spent'    => $lsPointsSpent,
            'points_discount' => $this->formatValue($pointDiscount),
            'point_rate'      => $this->formatValue($pointRate)
        ];
    }

    /**
     * Appy Loyalty Points
     * @param $cartId
     * @param $loyaltyPoints
     * @return bool
     * @throws CouldNotSaveException
     * @throws GraphQlInputException
     * @throws NoSuchEntityException
     */
    public function apply($cartId, $loyaltyPoints)
    {
        try {
            /** @var Quote $cart */
            $cartQuote = $this->quoteRepository->get($cartId);
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(
                __("Could not find a cart with ID %1", $cartId)
            );
        }

        if (!is_numeric($loyaltyPoints) || $loyaltyPoints < 0) {
            throw new GraphQlInputException(
                __("The loyalty points '%1' are not valid.", $loyaltyPoints)
            );
        }
        $itemsCount         = $cartQuote->getItemsCount();
        $isPointValid       = $this->loyaltyHelper->isPointsAreValid($loyaltyPoints);
        $orderBalance       = $cartQuote->getData('grand_total');
        $isPointsLimitValid = $this->loyaltyHelper->isPointsLimitValid(
            $orderBalance,
            $loyaltyPoints
        );
        if ($itemsCount && $isPointValid && $isPointsLimitValid) {
            $cartQuote->getShippingAddress()->setCollectShippingRates(true);
            $cartQuote->setLsPointsSpent($loyaltyPoints);
            $cartQuote->setTotalsCollectedFlag(false)->collectTotals();
            $this->quoteRepository->save($cartQuote);
        } else {
            throw new CouldNotSaveException(
                __("The loyalty points '%1' are not valid.", $loyaltyPoints)
            );
        }
        return true;
    }

    /**
     * Remove the loyalty points from quote
     * @param $cartId
     * @return bool
     * @throws NoSuchEntityException
     */
    public function remove($cartId)
    {
        try {
            /** @var Quote $cart */
            $cartQuote = $this->quoteRepository->get($cartId);
        } catch (NoSuchEntityException $e) {
            throw new NoSuchEntityException(
                __('Could not find a cart with ID %1', $cartId)
            );
        }
        if ($cartQuote->getLsPointsSpent()) {
            $loyaltyPoints = 0;
            $cartQuote->getShippingAddress()->setCollectShippingRates(true);
            $cartQuote->setLsPointsSpent($loyaltyPoints);
            $cartQuote->setTotalsCollectedFlag(false)->collectTotals();
            $this->quoteRepository->save($cartQuote);
        }
        return true;
    }

    /**
     * Format value to two decimal places
     * @param $value
     * @return float|string
     */
    public function formatValue($value)
    {
        return $this->currencyHelper->format($value, ['display' => \Zend_Currency::NO_SYMBOL], false);
    }
}
