<?php

namespace Ls\Webhooks\Model\Order;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\ShipOrderInterface;
use Magento\Sales\Api\Data\ShipmentItemCreationInterface;
use Magento\Sales\Api\Data\ShipmentInterface;
use Magento\Sales\Model\Order\Shipment\TrackFactory;
use Magento\Sales\Api\Data\ShipmentCommentCreationInterface;
use Magento\Shipping\Helper\Data as ShippingHelper;
use \Ls\Webhooks\Helper\Data;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Api\ShipmentRepositoryInterface;
use \Ls\Webhooks\Logger\Logger;

/**
 * class to create shipment through webhook
 */
class Shipment
{
    /**
     * @var ShipOrderInterface
     */
    private $shipOrderInterface;

    /**
     * @var ShipmentItemCreationInterface
     */
    private $shipmentItemCreationInterface;

    /**
     * @var ShipmentInterface
     */
    private $shipmentInterface;

    /**
     * @var Data
     */
    private $helper;

    /**
     * @var TrackFactory
     */
    private $trackFactory;

    /**
     * @var ShipmentCommentCreationInterface
     */
    private $shipmentCommentCreation;

    /**
     * @var ShippingHelper
     */
    private $shippingHelper;

    /**
     * @var ShipmentRepositoryInterface
     */
    private $shipmentRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * Shipment constructor.
     * @param ShipOrderInterface $shipOrderInterface
     * @param ShipmentItemCreationInterface $shipmentItemCreationInterface
     * @param ShipmentInterface $shipmentInterface
     * @param TrackFactory $trackFactory
     * @param ShipmentCommentCreationInterface $shipmentCommentCreation
     * @param Data $helper
     * @param ShippingHelper $shippingHelper
     */
    public function __construct(
        ShipOrderInterface $shipOrderInterface,
        ShipmentItemCreationInterface $shipmentItemCreationInterface,
        ShipmentInterface $shipmentInterface,
        TrackFactory $trackFactory,
        ShipmentCommentCreationInterface $shipmentCommentCreation,
        Data $helper,
        ShippingHelper $shippingHelper,
        ShipmentRepositoryInterface $shipmentRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Logger $logger
    ) {
        $this->shipOrderInterface            = $shipOrderInterface;
        $this->shipmentItemCreationInterface = $shipmentItemCreationInterface;
        $this->shipmentInterface             = $shipmentInterface;
        $this->trackFactory                  = $trackFactory;
        $this->shipmentCommentCreation       = $shipmentCommentCreation;
        $this->helper                        = $helper;
        $this->shippingHelper                = $shippingHelper;
        $this->shipmentRepository            = $shipmentRepository;
        $this->searchCriteriaBuilder         = $searchCriteriaBuilder;
        $this->logger                        = $logger;
    }

    /**
     * Creating shipment in Magento
     * @param $data
     * @return array[]
     * @throws NoSuchEntityException
     */
    public function createShipment($data)
    {
        $orderId             = $data['orderId'];
        $trackingId          = $data['trackingId'];
        $lsCentralShippingId = $data['lsCentralShippingId'];

        $magOrder        = $this->helper->getOrderByDocumentId($orderId);
        $status          = false;
        $statusMsg       = '';
        $shipmentItems   = [];
        $shipmentDetails = [];
        if (!empty($magOrder)) {
            if ($magOrder->canShip() && !$this->getShipmentExists($orderId, $lsCentralShippingId)) { //if shipment not exists create shipment
                $items    = $this->helper->getItems($magOrder, $data['lines']);
                $shipItem = [];
                foreach ($items as $itemData) {
                    $item                        = $itemData['item'];
                    $orderItemId                 = $item->getItemId();
                    $shipmentItems[$orderItemId] = $itemData['qty'];
                }
                if (count($shipmentItems) > 0) {
                    foreach ($shipmentItems as $orderItemId => $qty) {
                        $itemCreation = $this->shipmentItemCreationInterface;
                        $itemCreation->setOrderItemId($orderItemId)->setQty($qty);
                        $shipItem[] = clone $itemCreation;

                    }

                    $shipmentItemArray = $this->shipmentInterface->setItems($shipItem)->getItems();

                    $shipmentTracks = $this->trackFactory->create();
                    if (!empty($trackingId)) {
                        $shipmentTracks->setCarrierCode($data['shipmentProvider']);
                        $shipmentTracks->setTitle($data['service']);
                        $shipmentTracks->setDescription($data['service']);
                        $shipmentTracks->setTrackNumber($trackingId);
                    }

                    $this->shipmentCommentCreation->setComment(__("Shipment added from LS Central"))
                        ->setIsVisibleOnFront(0);

                    $shipmentId = $this->shipOrderInterface->execute(
                        $magOrder->getEntityId(),
                        $shipmentItemArray,
                        true,
                        false,
                        $this->shipmentCommentCreation,
                        [$shipmentTracks]
                    );

                    $shipmentDetails = $this->getShipmentDetailsByOrder($magOrder, $shipmentId, $lsCentralShippingId);
                    $status          = true;
                    $statusMsg       = "Shipment posted successfully.";
                }
            } else { //if shipment exists update tracking number

                $status    = $this->updateTrackingId($orderId, $lsCentralShippingId, $trackingId);
                $statusMsg = ($status) ? "Tracking Id updated successfully." : "Tracking Id update failed";

            }
        }

        return $this->helper->outputShipmentMessage(
            $status,
            $statusMsg,
            $shipmentDetails
        );
    }

    /** Get Shipment exists status based on shipment Id from Central
     * @param $orderId
     * @param $shipmentId
     * @return bool
     */
    public function getShipmentExists($orderId, $shipmentId)
    {
        $magOrder           = $this->helper->getOrderByDocumentId($orderId);
        $shipmentCollection = $magOrder->getTracksCollection();
        $shipmentExists     = false;
        foreach ($shipmentCollection->getItems() as $shipment) {
            if ($shipment->getShipmentId() == $shipmentId) {
                $shipmentExists = true;
            }
        }

        return $shipmentExists;
    }

    /** Update central tracking Id
     *
     * @param $orderId
     * @param $lsCentralShippingId
     * @param $trackingId
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function updateTrackingId($orderId, $lsCentralShippingId, $trackingId)
    {
        $magOrder           = $this->helper->getOrderByDocumentId($orderId);
        $shipmentCollection = $magOrder->getTracksCollection();
        $status             = false;
        try {
            foreach ($shipmentCollection->getItems() as $shipment) {

                if ($shipment->getLsCentralShippingId() == $lsCentralShippingId) {
                    $shipment->setTrackNumber($trackingId);
                    $shipment->save();
                    $status = true;
                }
            }
        } catch (\Exception $e) {
            $this->logger->critical($e);
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __('Could not update Tracking Id, see error log for details')
            );
        }


        return $status;
    }

    /**
     * Get Shipment details by order
     *
     * @param $magOrder
     * @param $shipmentId
     * @param $lsCentralShippingId
     * @return array
     */
    public function getShipmentDetailsByOrder($magOrder, $shipmentId, $lsCentralShippingId)
    {
        $trackDataArray  = [];
        $trackData       = [];
        $shipmentDetails = $magOrder->getTracksCollection();
        foreach ($shipmentDetails->getItems() as $trackInfo) {
            if ($shipmentId == $trackInfo->getParentId()) {
                $trackData ['trackingId']       = $trackInfo->getTrackNumber();
                $trackData ['trackingUrl']      = $this->shippingHelper->getTrackingPopupUrlBySalesModel($magOrder);
                $trackData ['shipmentProvider'] = $trackInfo->getCarrierCode();
                $trackData ['service']          = $trackInfo->getTitle();

                //Sync LS central shipping Id to shipment track
                $trackInfo->setLsCentralShippingId($lsCentralShippingId);
                $trackInfo->save();
            }
            $trackDataArray [] = $trackData;
        }

        return $trackDataArray;
    }
}
