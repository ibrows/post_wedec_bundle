<?php


namespace Ibrows\PostWedecBundle\Api\Delivery\WedecDeliveryBundle\Model;


interface WedecAddressInterface
{
    /**
     * @return string
     */
    public function getStreet();

    /**
     * @return string
     */
    public function getHouseNumber();

    /**
     * @return string
     */
    public function getCity();

    /**
     * @return string
     */
    public function getZipCode();
}