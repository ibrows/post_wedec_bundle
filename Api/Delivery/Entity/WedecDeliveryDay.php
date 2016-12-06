<?php


namespace Ibrows\PostWedecBundle\Api\Delivery\WedecDeliveryBundle\Entity;


use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;

class WedecDeliveryDay
{
    /*
     * The type of activities provided by SwissPost on this deliveryDate are dependent on the type of day.
     */
    /**
     * WORK - Delivery services by the Swiss Post are available that day
     */
    const ACTIVITY_WORK = 'WORK';
    /**
     * SUNDAY - No delivery service by the Swiss Post is available on Sundays,
     */
    const ACTIVITY_SUNDAY = 'SUNDAY';
    /**
     * HOLIDAY - No delivery service by the Swiss Post is available that day at the address because of holiday,
     */
    const ACTIVITY_HOLIDAY = 'HOLIDAY';
    /**
     * NO_SERVICE - No delivery service by the Swiss Post is available that day at the address because of multiple reasons
     */
    const ACTIVITY_NO_SERVICE = 'NO_SERVICE';

    /**
     * @var \DateTime
     * @Type("DateTime<'Y-m-d'>")
     * @Serializer\SerializedName("deliveryDate")
     */
    private $deliveryDate;

    /**
     * @Type("array<Ibrows\PostWedecBundle\Api\Delivery\WedecDeliveryBundle\Entity\WedecDeliverability>")
     * @Serializer\SerializedName("deliverabilities")
     * @var WedecDeliverability[]
     */
    private $deliverabilities = [];

    /**
     * @var string
     * @Type("string")
     * @Serializer\SerializedName("activity")
     */
    private $activity;

    /**
     * @return \DateTime
     */
    public function getDeliveryDate()
    {
        return $this->deliveryDate;
    }

    /**
     * @param \DateTime $deliveryDate
     */
    public function setDeliveryDate(\DateTime $deliveryDate)
    {
        $this->deliveryDate = $deliveryDate;
    }

    /**
     * @return WedecDeliverability[]
     */
    public function getDeliverabilities()
    {
        return $this->deliverabilities;
    }

    /**
     * @param WedecDeliverability[] $deliverabilities
     */
    public function setDeliverabilities(array $deliverabilities)
    {
        $this->deliverabilities = $deliverabilities;
    }

    /**
     * @return string
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * @param string $activity
     */
    public function setActivity(string $activity)
    {
        $this->activity = $activity;
    }
}