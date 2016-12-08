<?php


namespace Ibrows\PostWedecBundle\Api\Delivery;

use Ibrows\PostWedecBundle\Api\Delivery\Entity\WedecDeliverabilityResponse;
use Ibrows\PostWedecBundle\Api\Delivery\Model\WedecAddressInterface;
use Ibrows\PostWedecBundle\Api\Delivery\Model\WedecDeliveryAddressInterface;
use Ibrows\PostWedecBundle\Api\Delivery\Model\WedecOAuthClientInterface;
use Ibrows\PostWedecBundle\Api\Delivery\Util\WedecDeliverabilitiesUriBuilder;
use Ibrows\PostWedecBundle\Api\Delivery\Util\WedecOAuthUriBuilder;
use Ibrows\PostWedecBundle\Api\Delivery\Util\WedecObjectSerializer;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class WedecDeliveryManager - In charge of processing responses, building Requests, and giving them back as
 * RequestInterface.
 * @package Ibrows\PostWedecBundle\Api\Delivery
 */
class WedecDeliveryManager implements WedecOAuthClientInterface
{
    // can move to config for this service
    const BASE_URI = 'https://wedec.post.ch';
    const BASE_INT_URI = 'https://wedecint.post.ch';

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var WedecObjectSerializer
     */
    private $serializer;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * WedecDeliveryManager constructor.
     * @param string $clientId
     * @param string $clientSecret
     * @param WedecObjectSerializer $serializer
     */
    public function __construct($clientId, $clientSecret, $serializer)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->serializer = $serializer;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * Base URI depending on the environment.
     * @return string
     */
    public function getBaseUri()
    {
        //return self::BASE_INT_URI
        return self::BASE_URI;
    }

    /**
     * @return RequestInterface
     */
    public function getOAuthRequest()
    {
        $request = new Request(
            'POST',
            WedecOAuthUriBuilder::getOAuthUri($this->getBaseUri(), $this, self::SCOPE_DELIVERY),
            WedecOAuthUriBuilder::contentTypeUrlEncoded()
        );

        return $request;
    }

    /**
     * @param WedecDeliveryAddressInterface $address
     * @return Request|null|RequestInterface
     */
    public function getDeliverabilitiesRequestWithAddress(WedecDeliveryAddressInterface $address)
    {
        if (null === $address) {
            throw new \InvalidArgumentException('$address cannot be null for creating Deliverabilities Request.');
        }

        if (null === $this->accessToken) {
            //TODO: throw a domain specific exception
            return null;
        }

        if (count($address->getDeliveryDates()) > 0) {
            return $this->getDeliveryDatesDeliverablitiesRequest($address);
        }
        return $this->getDateDeliverabilitiesRequest($address);
    }

    /**
     * @param string $json
     */
    public function setAccessTokenWithJson($json)
    {
        $this->setAccessToken($this->getAccessTokenForJsonResponse($json));
    }

    /**
     * @param ResponseInterface $response
     */
    public function setAccessTokenWithResponse(ResponseInterface $response)
    {
        if (200 === $response->getStatusCode()) {
            $this->setAccessTokenWithJson($response->getBody());
        }
        // TODO: throw an exception - domain specific
    }


    /**
     * @param ResponseInterface $response
     * @param bool $reliable
     * @param bool $usable
     * @return null|Entity\WedecDeliveryDay[]
     */
    public function getDeliveryDays(ResponseInterface $response, $reliable = true, $usable = true)
    {
        $json = $response->getBody();

        $days = $this->getDeliveryDaysForJsonResponse($json, $reliable, $usable);

        return $days;
    }

    /**
     * @param $response
     * @return string as accessToken
     */
    private function getAccessTokenForJsonResponse($response)
    {
        $oauthResponse = $this->serializer->deserializeOAuthResponse($response);
        return $oauthResponse->getAccessToken();
    }

    /**
     * @param $json
     * @param bool $reliable
     * @param bool $usable
     * @return Entity\WedecDeliveryDay[]|null
     */
    private function getDeliveryDaysForJsonResponse($json, $reliable, $usable)
    {
        $dResponse = $this->serializer->deserializeDeliverabilityResponse($json);

        if (($usable && ($dResponse->getQuality() === WedecDeliverabilityResponse::QUALITY_USABLE)) ||
            ($reliable && ($dResponse->getQuality() === WedecDeliverabilityResponse::QUALITY_RELIABLE))
        ) {
            return $dResponse->getDays();
        }
        return null;
    }

    /**
     * @param WedecDeliveryAddressInterface $address
     * @return RequestInterface
     */
    private function getDateDeliverabilitiesRequest(WedecDeliveryAddressInterface $address)
    {
        $request = new Request(
            'GET',
            WedecDeliverabilitiesUriBuilder::getDateUri($this->getBaseUri(), $address),
            WedecOAuthUriBuilder::authorizationHeadersWithToken($this->getAccessToken())
        );

        return $request;
    }

    /**
     * @param WedecAddressInterface $address
     * @return Request
     */
    private function getDeliveryDatesDeliverablitiesRequest(WedecAddressInterface $address)
    {
        $request = new Request(
            'GET',
            WedecDeliverabilitiesUriBuilder::getDeliveryDatesUri($this->getBaseUri(), $address),
            WedecOAuthUriBuilder::authorizationHeadersWithToken($this->getAccessToken())
        );

        return $request;
    }


    /**
     * @param WedecDeliveryAddressInterface $address
     * @return array
     */
    private function getDeliverabilitiesRequestQuery(WedecDeliveryAddressInterface $address)
    {
        return [
            'query' => WedecDeliverabilitiesUriBuilder::dateParametersWithAddress($address),
        ];
    }

    /**
     * @param WedecDeliveryAddressInterface $address
     * @return array
     */
    private function getDeliveryDatesRequestQuery(WedecDeliveryAddressInterface $address)
    {
        return [
            'query' => WedecDeliverabilitiesUriBuilder::deliveryDatesParametersWithAddress($address),
        ];
    }

    /**
     * @param string $accessToken
     */
    private function setAccessToken($accessToken)
    {
        if (!is_string($accessToken)) {
            throw new \InvalidArgumentException('$accessToken Must be String');
        }
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    private function getAccessToken()
    {
        return $this->accessToken;
    }
}