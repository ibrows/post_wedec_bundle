<?php


namespace Ibrows\PostWedecBundle\Api\Delivery\Entity;


use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\Type;

class WedecDeliverabilityResponse
{
    /**
     * The quality of the returned delivery days
     */
    /**
     * RELIABLE - The result is exact and reliable,
     */
    const QUALITY_RELIABLE = 'RELIABLE';
    /**
     * USABLE - The result is usable but its accuracy cannot be ensured
     */
    const QUALITY_USABLE = 'USABLE';
    /**
     * NOT_USABLE - The system was not able to delivery an acceptable result
     */
    const QUALITY_NOT_USABLE = 'NOT_USABLE';

    /**
     * @Type("array<Ibrows\PostWedecBundle\Api\Delivery\Entity\WedecDeliveryDay>")
     * @SerializedName("days")
     * @var WedecDeliveryDay[]
     */
    private $days = [];

    /**
     * @var string
     * @Type("string")
     * @SerializedName("quality")
     */
    private $quality;

    /**
     * @return WedecDeliveryDay[]
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param WedecDeliveryDay[] $days
     */
    public function setDays($days)
    {
        $this->days = $days;
    }

    /**
     * @return string
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @param string $quality
     */
    public function setQuality(string $quality)
    {
        $this->quality = $quality;
    }
}