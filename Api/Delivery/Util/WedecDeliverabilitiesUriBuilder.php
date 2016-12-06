<?php


namespace Ibrows\PostWedecBundle\Api\Delivery\WedecDeliveryBundle\Util;


use Ibrows\PostWedecBundle\Api\Delivery\WedecDeliveryBundle\Model\WedecAddressInterface;
use Ibrows\PostWedecBundle\Api\Delivery\WedecDeliveryBundle\Model\WedecDeliveryAddressInterface;

class WedecDeliverabilitiesUriBuilder
{
    const STREET_KEY            = 'address.geographicLocation.house.street';
    const HOUSE_NUMBER_KEY      = 'address.geographicLocation.house.houseNumber';
    const ZIP_CODE_KEY          = 'address.geographicLocation.zip.zip';
    const CITY_KEY              = 'address.geographicLocation.zip.city';
    const DAY_COUNT_KEY         = 'dayCount';
    const DELIVERY_DATES_KEY    = 'deliveryDates';
    const DELIVERY_DATE         = 'date';

    const DELIVERABLITIES_URI_POSTFIX = '/api/delivery/v1/deliverabilities/when?';

    /**
     * @param string $baseUri
     * @param WedecAddressInterface $address
     * @return string
     */
    public static function getDateUri(string $baseUri, WedecAddressInterface $address)
    {
        return self::getDeliverablitiesUriPrefix($baseUri) . self::dateParametersUriWithAddress($address);
    }

    /**
     * @param string $baseUri
     * @param WedecAddressInterface $address
     * @return string
     */
    public static function getDeliveryDatesUri(string $baseUri, WedecAddressInterface $address)
    {
        return self::getDeliverablitiesUriPrefix($baseUri) . self::deliveryDatesParametersUriWithAddress($address);
    }

    /**
     * Helper method to build URI array parameters given a starting date for a given number of
     * days (if dayCount is set).
     * @param WedecDeliveryAddressInterface $address
     * @return array
     */
    public static function dateParametersWithAddress(WedecDeliveryAddressInterface $address)
    {
        $params = self::buildCommonParamsArray($address);
        if (!is_null($address->getDayCount())) {
            $params[self::DAY_COUNT_KEY] = $address->getDayCount(); /* 14 days if null*/
        }
        $params[self::DELIVERY_DATE] = $address->getStartDate();

        return $params;
    }

    /**
     * Helper method to build URI string parameters given a starting date for a given number of
     * days (if dayCount is set).
     * @param WedecDeliveryAddressInterface $address
     * @return string
     */
    public static function dateParametersUriWithAddress(WedecDeliveryAddressInterface $address)
    {
        $paramsStr = self::buildCommonParamsString($address);
        if (!is_null($address->getDayCount())) {
            $paramsStr .= '&' . self::DAY_COUNT_KEY . '=' . $address->getDayCount();
        }
        if (!is_null($address->getStartDate())) {
            $paramsStr .= '&' . self::DELIVERY_DATE . '=' . $address->getStartDate();
        }
        return $paramsStr;
    }

    /**
     * Helper method to build URI parameters
     * @param WedecDeliveryAddressInterface $address
     * @return array
     */
    public static function deliveryDatesParametersWithAddress(WedecDeliveryAddressInterface $address)
    {
        $params = self::buildCommonParamsArray($address);
        $params[self::DELIVERY_DATES_KEY] = $address->getDeliveryDates();
        return $params;
    }

    /**
     * @param WedecDeliveryAddressInterface $address
     * @return string
     */
    public static function deliveryDatesParametersUriWithAddress(WedecDeliveryAddressInterface $address)
    {
        $paramsStr = self::buildCommonParamsString($address);

        foreach ($address->getDeliveryDates() as $date) {
            $paramsStr .= '&' . self::DELIVERY_DATES_KEY . '=' . $date;
        }

        return $paramsStr;
    }

    private static function buildCommonParamsArray(WedecDeliveryAddressInterface $address)
    {
        return [
            self::STREET_KEY        => $address->getStreet(),
            self::HOUSE_NUMBER_KEY  => $address->getHouseNumber(),
            self::ZIP_CODE_KEY      => $address->getZipCode(),
            self::CITY_KEY          => $address->getCity(),
        ];
    }

    private static function buildCommonParamsString(WedecDeliveryAddressInterface $address)
    {
        $paramsStr = self::STREET_KEY . '=' . $address->getStreet() . '&';
        $paramsStr .= self::HOUSE_NUMBER_KEY . '=' . $address->getHouseNumber() . '&';
        $paramsStr .= self::CITY_KEY . '=' . $address->getCity() . '&';
        $paramsStr .= self::ZIP_CODE_KEY . '=' . $address->getZipCode();
        return $paramsStr;
    }

    /**
     * @param string $baseUri
     * @return string
     */
    private function getDeliverablitiesUriPrefix(string $baseUri)
    {
        return $baseUri . self::DELIVERABLITIES_URI_POSTFIX;
    }


}