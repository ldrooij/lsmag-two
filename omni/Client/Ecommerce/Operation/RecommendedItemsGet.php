<?php
/**
 * THIS IS AN AUTOGENERATED FILE
 * DO NOT MODIFY
 */


namespace Ls\Omni\Client\Ecommerce\Operation;

use Ls\Omni\Client\RequestInterface;
use Ls\Omni\Client\ResponseInterface;
use Ls\Omni\Client\AbstractOperation;
use Ls\Omni\Service\Service as OmniService;
use Ls\Omni\Service\ServiceType;
use Ls\Omni\Service\Soap\Client as OmniClient;
use Ls\Omni\Client\Ecommerce\ClassMap;
use Ls\Omni\Client\Ecommerce\Entity\RecommendedItemsGet as RecommendedItemsGetRequest;
use Ls\Omni\Client\Ecommerce\Entity\RecommendedItemsGetResponse as RecommendedItemsGetResponse;

class RecommendedItemsGet extends AbstractOperation
{

    const OPERATION_NAME = 'RECOMMENDED_ITEMS_GET';

    const SERVICE_TYPE = 'ecommerce';

    /**
     * @property OmniClient $client
     */
    public $client = null;

    /**
     * @property RecommendedItemsGetRequest $request
     */
    private $request = null;

    /**
     * @property RecommendedItemsGetResponse $response
     */
    private $response = null;

    /**
     * @property RecommendedItemsGetRequest $request_xml
     */
    private $request_xml = null;

    /**
     * @property RecommendedItemsGetResponse $response_xml
     */
    private $response_xml = null;

    /**
     * @property mixed $error
     */
    private $error = null;

    /**
     * @param ServiceType $service_type
     */
    public function __construct()
    {
        $service_type = new ServiceType( self::SERVICE_TYPE );
        parent::__construct( $service_type );
        $url = OmniService::getUrl( $service_type ); 
        $this->client = new OmniClient( $url, $service_type );
        $this->client->setClassmap( $this->getClassMap() );
    }

    /**
     * @param RecommendedItemsGetRequest $request
     * @return ResponseInterface|RecommendedItemsGetResponse
     */
    public function execute(RequestInterface $request = null)
    {
        if ( !is_null( $request ) ) {
            $this->setRequest( $request );
        }
        return $this->makeRequest( 'RecommendedItemsGet' );
    }

    /**
     * @return RecommendedItemsGetRequest
     */
    public function & getOperationInput()
    {
        if ( is_null( $this->request ) ) {
            $this->request = new RecommendedItemsGetRequest();
        }
        return $this->request;
    }

    /**
     * @return array
     */
    public function getClassMap()
    {
        return ClassMap::getClassMap();
    }

    protected function isTokenized()
    {
        return FALSE;
    }

    /**
     * @param OmniClient $client
     * @return $this
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return OmniClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param RecommendedItemsGetRequest $request
     * @return $this
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return RecommendedItemsGetRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param RecommendedItemsGetResponse $response
     * @return $this
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return RecommendedItemsGetResponse
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param RecommendedItemsGetRequest $request_xml
     * @return $this
     */
    public function setRequestXml($request_xml)
    {
        $this->request_xml = $request_xml;
        return $this;
    }

    /**
     * @return RecommendedItemsGetRequest
     */
    public function getRequestXml()
    {
        return $this->request_xml;
    }

    /**
     * @param RecommendedItemsGetResponse $response_xml
     * @return $this
     */
    public function setResponseXml($response_xml)
    {
        $this->response_xml = $response_xml;
        return $this;
    }

    /**
     * @return RecommendedItemsGetResponse
     */
    public function getResponseXml()
    {
        return $this->response_xml;
    }

    /**
     * @param mixed $error
     * @return $this
     */
    public function setError($error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }


}

