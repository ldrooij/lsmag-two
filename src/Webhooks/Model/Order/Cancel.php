<?php

namespace Ls\Webhooks\Model\Order;

use \Ls\Webhooks\Logger\Logger;
use \Ls\Webhooks\Helper\Data;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\ItemRepository;

/**
 * class to cancel order through webhook
 */
class Cancel
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var OrderManagementInterface
     */
    private $orderManagement;

    /**
     * @var Data
     */
    private $helper;

    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * Cancel constructor.
     * @param OrderManagementInterface $orderManagement
     * @param ItemRepository $itemRepository
     * @param Data $helper
     * @param Logger $logger
     */
    public function __construct(
        OrderManagementInterface $orderManagement,
        ItemRepository $itemRepository,
        Data $helper,
        Logger $logger
    ) {
        $this->orderManagement = $orderManagement;
        $this->itemRepository  = $itemRepository;
        $this->helper          = $helper;
        $this->logger          = $logger;
    }

    /**
     * cancel order
     * @param $orderId
     */
    public function cancelOrder($orderId)
    {
        try {
            $this->orderManagement->cancel($orderId);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }

    /**
     * For cancelling order item
     * @param $magOrder
     * @param $items
     * @return void
     */
    public function cancelItems($magOrder, $items)
    {
        if ($magOrder->canCancel()) {
            foreach ($items as $itemData) {
                $item               = $itemData['item'];
                $cancellationAmount = $itemData['amount'];
                $item->setQtyCanceled($item->getQtyCanceled() + $itemData['qty']);
                $this->itemRepository->save($item);

                $magOrder->setTotalCanceled($magOrder->getTotalCanceled() + $cancellationAmount);
                $magOrder->setBaseTotalCanceled($magOrder->getBaseTotalCanceled() + $cancellationAmount);

                $this->helper->getOrderRepository()->save($magOrder);
            }
        }
    }
}
