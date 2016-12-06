<?php


namespace Ibrows\PostWedecBundle\Api\Delivery\WedecDeliveryBundle\Model;


interface WedecDeliveryAddressInterface extends WedecAddressInterface
{
    /**
     * @return array
     */
    public function getDeliveryDates();

    /**
     * @return int
     */
    public function getDayCount();

    /**
     * @return string
     */
    public function getStartDate();
}