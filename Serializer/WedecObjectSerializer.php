<?php


namespace Ibrows\PostWedecBundle\Serializer;


use Ibrows\PostWedecBundle\Api\Delivery\WedecDeliveryBundle\Entity\WedecDeliverabilityResponse;
use Ibrows\PostWedecBundle\Api\Delivery\WedecDeliveryBundle\Entity\WedecOAuthResponse;
use JMS\Serializer\Serializer;

class WedecObjectSerializer
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * WedecObjectSerializer constructor.
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param $response
     * @param string $format defaults to JSON
     * @return array|WedecOAuthResponse
     */
    public function deserializeOAuthResponse($response, $format = 'json')
    {
        return $this->serializer->deserialize($response, WedecOAuthResponse::class, $format);
    }

    /**
     * @param $response
     * @param string $format
     * @return array|WedecDeliverabilityResponse
     */
    public function deserializeDeliverabilityResponse($response, $format = 'json')
    {
        return $this->serializer->deserialize($response, WedecDeliverabilityResponse::class, $format);
    }
}