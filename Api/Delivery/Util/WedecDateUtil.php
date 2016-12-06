<?php


namespace Ibrows\PostWedecBundle\Api\Delivery\WedecDeliveryBundle\Util;


class WedecDateUtil
{
    const JSON_DATE_FORMAT = 'Y-m-d';
    /**
     * @param \DateTime $date
     * @return string date in 'Y-m-d' format (ie: 2000-01-21)
     */
    public static function dateToString(\DateTime $date)
    {
        return $date->format(self::JSON_DATE_FORMAT);
    }

    /**
     * @param string $dateString
     * @return bool|\DateTime
     */
    public static function stringToDate(string $dateString)
    {
        if (self::isValidDateFormat($dateString)) {
            return new \DateTime($dateString);
        }
        return \DateTime::createFromFormat(self::JSON_DATE_FORMAT, $dateString);
    }

    /**
     * @param $date
     * @param string $format
     * @return bool
     */
    public static function isValidDateFormat($date, $format = self::JSON_DATE_FORMAT)
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}