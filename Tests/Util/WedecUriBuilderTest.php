<?php


namespace GoDoItBundle\Tests\Delivery\WedecDeliveryBundle\Util;


use GoDoItBundle\Delivery\WedecDeliveryBundle\Model\WedecDeliveryAddressInterface;
use GoDoItBundle\Delivery\WedecDeliveryBundle\Model\WedecOAuthClientInterface;
use GoDoItBundle\Delivery\WedecDeliveryBundle\Util\WedecDeliverabilitiesUriBuilder;
use GoDoItBundle\Delivery\WedecDeliveryBundle\Util\WedecOAuthUriBuilder;

class WedecUriBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testOAuthParams()
    {
        $params = WedecOAuthUriBuilder::getOAuthParametersWithCredentials($this->getSampleClient(), 'DELIVERY');

        $this->assertNotNull($params);
        $this->assertCount(4, $params);
        $this->assertEquals(4, count($params));

        $this->assertEquals('DELIVERY', $params['scope']);
        $this->assertEquals('0123', $params['client_id']);
        $this->assertEquals('pass', $params['client_secret']);
    }

    public function testOAuthUriParams()
    {
        $params = WedecOAuthUriBuilder::getOAuthUriParametersWithCredentials($this->getSampleClient(), 'DELIVERY');
        $this->assertNotNull($params);

        $this->assertSame(
            'grant_type=client_credentials&client_id=0123&client_secret=pass&scope=DELIVERY',
            $params
        );
    }

    public function testDateParams()
    {
        $params = WedecDeliverabilitiesUriBuilder::dateParametersWithAddress($this->getSampleAddress());

        $this->assertNotNull($params);
        $this->assertCount(5, $params);
        $this->assertEquals(5, count($params));

        $this->assertEquals('Zurich', $params[WedecDeliverabilitiesUriBuilder::CITY_KEY]);
        $this->assertEquals('Seestrasse', $params[WedecDeliverabilitiesUriBuilder::STREET_KEY]);
        $this->assertEquals('2016-11-25', $params[WedecDeliverabilitiesUriBuilder::DELIVERY_DATE]);
        $this->assertArrayNotHasKey(WedecDeliverabilitiesUriBuilder::DAY_COUNT_KEY, $params);
    }

    public function testDateUriParams()
    {
        $params = WedecDeliverabilitiesUriBuilder::dateParametersUriWithAddress($this->getSampleAddress());

        $this->assertNotNull($params);

        $this->assertFalse(strpos($params, WedecDeliverabilitiesUriBuilder::DAY_COUNT_KEY));

        $this->assertSame(
            'address.geographicLocation.house.street=Seestrasse&address.geographicLocation.house.houseNumber=356&address.geographicLocation.zip.city=Zurich&address.geographicLocation.zip.zip=8038&date=2016-11-25',
            $params
        );
    }

    /**
     * @return WedecDeliveryAddressInterface
     */
    private function getSampleAddress()
    {
        $address = $this->getMockBuilder(WedecDeliveryAddressInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $address->method('getStreet')->willReturn('Seestrasse');
        $address->method('getHouseNumber')->willReturn('356');
        $address->method('getZipCode')->willReturn('8038');
        $address->method('getCity')->willReturn('Zurich');
        $address->method('getDayCount')->willReturn(null);
        $address->method('getStartDate')->willReturn('2016-11-25');

        return $address;
    }


    /**
     * @return WedecOAuthClientInterface
     */
    private function getSampleClient()
    {
        $client = $this->getMockBuilder(WedecOAuthClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $client->method('getClientId')->willReturn('0123');
        $client->method('getClientSecret')->willReturn('pass');
        return $client;
    }
}
