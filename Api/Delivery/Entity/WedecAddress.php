<?php


namespace Ibrows\PostWedecBundle\Api\Delivery\WedecDeliveryBundle\Entity;


use Ibrows\PostWedecBundle\Api\Delivery\WedecDeliveryBundle\Model\WedecAddressInterface;

class WedecAddress implements WedecAddressInterface
{
    /**
     * @var string
     */
    private $street;
    /**
     * @var int
     */
    private $houseNumber;
    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $zipCode;

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @param string $houseNumber
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

}