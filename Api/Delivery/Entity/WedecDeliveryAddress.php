<?php


namespace Ibrows\PostWedecBundle\Api\Delivery\Entity;


use Ibrows\PostWedecBundle\Api\Delivery\Model\WedecDeliveryAddressInterface;
use Ibrows\PostWedecBundle\Api\Delivery\Util\WedecDateUtil;

class WedecDeliveryAddress extends WedecAddress implements WedecDeliveryAddressInterface
{
    /**
     * @var int
     */
    private $dayCount;

    /**
     * @var array
     */
    private $deliveryDates;

    /**
     * @var string
     */
    private $startDate;

    /**
     * @return array
     */
    public function getDeliveryDates()
    {
        return $this->deliveryDates;
    }

    /**
     * @return mixed
     */
    public function getDayCount()
    {
        return $this->dayCount;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param int $dayCount
     */
    public function setDayCount(int $dayCount)
    {
        $this->dayCount = $dayCount;
    }

    /**
     * @param array $deliveryDates
     */
    public function setDeliveryDates(array $deliveryDates)
    {
        $this->deliveryDates = $this->convertAndValidateDates($deliveryDates);
    }

    /**
     * @param $startDate mixed|\DateTime|string
     */
    public function setStartDate($startDate)
    {
        if (is_string($startDate)) {
            if (WedecDateUtil::isValidDateFormat($startDate)) {
                $this->startDate = $startDate;
                return;
            }
        } else if ($startDate instanceof \DateTime) {
            $this->startDate = WedecDateUtil::dateToString($startDate);
            return;
        }
        throw new \InvalidArgumentException('$startDate is not a valid format!');
    }

    /**
     * @param $dates array of dates
     * @return array validated array of dates
     */
    private function convertAndValidateDates($dates) {
        $validated = [];
        foreach ($dates as $date) {
            if ($date instanceof \DateTime) {
                $validated[] = WedecDateUtil::dateToString($date);
            } else if (is_string($date) && WedecDateUtil::isValidDateFormat($date)) {
                $validated[] = $date;
            } else {
                throw new \InvalidArgumentException('Invalid format $dates passed!');
            }
        }
        return $validated;
    }


}