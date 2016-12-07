<?php


namespace GoDoItBundle\Tests\Delivery\WedecDeliveryBundle\Util;


use GoDoItBundle\Delivery\WedecDeliveryBundle\Entity\WedecDeliverability;
use GoDoItBundle\Delivery\WedecDeliveryBundle\Entity\WedecDeliveryDay;
use GoDoItBundle\Delivery\WedecDeliveryBundle\Util\WedecObjectSerializer;
use GoDoItBundle\Tests\ShopTestCase;
use JMS\Serializer\SerializerBuilder;

class WedecObjectSerializerTest extends ShopTestCase
{
    /**
     * @var WedecObjectSerializer
     */
    private $serializer;

    protected function setUp()
    {
        $serializer = SerializerBuilder::create()->build();
        $this->serializer = new WedecObjectSerializer($serializer);
    }

    public function testObjectCreation()
    {
        $this->assertNotNull($this->serializer);
        $this->assertInstanceOf(WedecObjectSerializer::class, $this->serializer);
    }

    public function testTokenDeserialization()
    {
        $json = $this->getTokenJson();
        $expectedToken = 'eyJlbmMiOiJBMjU2R0NNIiwiYWxnIjoiUlNBMV81In0.U6n7ukU_06r9siXfEECaN08RFoqb7_256oSAUgd0ImkuxVTqKHI2sIFceTuyH7srNEBuJPURyjbxNy---zStkm5f61PiI24aybHe2SOHUeJZECaqaiGsFhe-crBsUIupOXVDskSj7Vf1EcjD2fOhM0df1_ynI0w2Q8QLH2pll65jHYqLfaMKiW2Je3Kj7LxQyybVVuPf6F3JvyN3K69GMiJ9ch87_u2pT9HdbeupiIPfrnQFJGR7KQtuhqLxJ_I7TtEZ1z28yfiGWWLXC41IaYALV2EyIpvomJhB6kybuFl-3CUvXUbz64TwuirkL-yxyb4xl4U73SwWuiyHaq8z9Q.56KSiq70iIPMuUiY.PUpfu6dlSv-SkuBtHMfnDfJGQxpq1tqn65bnpH6mN9OPhtBv0PumlOtRb-apqPu-rD2Z1VWfycXN5BjaV6-vEX2Trhz134sL5DBWaJavr3gRAUp6ssj9fgq0io1Z21jw1ILuD_LD5K0YaTU-rnKZY2oHpGI1Yx0Epx7oKFXa4RIcfY4oEIIfXFC-KlSBfIRxnTIrcZ88-9djfR6ZQaD26C9pYdqKJw7MIRVRYNhLiV77StuBx7PbgFpFo-UxiPNZ0oslw5QgPB2jRwWp8a1ecfwzttQKU1YYkBsvkpv6EgRaAIE11dCO8SyytXUWGcLAgR3FW6bOaXj18TKCkjftu3k_rHKHb48odUwU3EMOrmTpM9JgJ7aJjveQwe7GENzE8t2G2ObiwniK75Ise6pqu2pFqexszdTdRuT_2I1iSwHlmspNrZ3WH3biqTa5TdVObU30O172EW-CtxgTZNYH43EEr1McQijImTdBLw4abMrMTtaE1hK64bvmU7K94R6NdsQIO9SdB73__tBGyct6XHSplnZdRCVOMJm4CU-hfGtehg2Wld0jbCK2vQJ_GQ9DMkvTdw1vl-9BEy-8xdGAwp5hIhNUK6POpoNFqBDZDNpzmOugiTdYiuBl0rAFXs3Df2FVjk-fPBJKY5BfdQ0GVT9pMyQJU1XcO9q-XO-J55EylEuU6Nugvzb5kMUf74yMqqHizSnYKz2u1z7gR_aJzknUxSnulS9s8EJDDJOxItyGOc8gQVuah_0j7_-wJbi2n7SWS9vPJcs.j31RF27mdAZ0mBiqeKfFVA';

        $this->assertNotNull($json);
        $this->assertJson($json);

        $oauthResponse = $this->serializer->deserializeOAuthResponse($json);
        $this->assertNotNull($oauthResponse);
        $this->assertSame('Bearer', $oauthResponse->getTokenType());
        $this->assertSame(300, $oauthResponse->getExpiresIn());

        $token = $oauthResponse->getAccessToken();
        $this->assertStringStartsWith('eyJlbmM', $token);
        $this->assertSame($expectedToken, $token);
    }


    public function testDeliverablity()
    {
        $json = $this->getDeliverablityJson();

        $this->assertNotNull($json);
        $this->assertJson($json);

        $response = $this->serializer->deserializeDeliverabilityResponse($json);
        $this->assertNotNull($response);
        $this->assertSame('RELIABLE', $response->getQuality());

        $days = $response->getDays();
        $this->assertCount(6, $days);

        $secondDay = $days[1];
        $twenty3rd = \DateTime::createFromFormat('Y-m-d', '2016-12-23');
        $this->assertInstanceOf(WedecDeliveryDay::class, $secondDay);
        $this->assertEquals('WORK', $secondDay->getActivity());
        $this->assertCount(4, $secondDay->getDeliverabilities());
        $this->assertInstanceOf(\DateTime::class, $secondDay->getDeliveryDate());
        $this->assertEquals($twenty3rd, $secondDay->getDeliveryDate());

        $thirdDeliverability = $secondDay->getDeliverabilities()[2];
        $this->assertNotNull($thirdDeliverability);
        $this->assertInstanceOf(WedecDeliverability::class, $thirdDeliverability);
        $this->assertEquals($twenty3rd, $thirdDeliverability->getIncomingDate());
        $this->assertStringStartsWith(WedecDeliverability::PRODUCT_CODE_AZS, $thirdDeliverability->getProductCode());
        $this->assertStringEndsWith(WedecDeliverability::PRODUCT_CODE_DIR, $thirdDeliverability->getProductCode());
    }

    /**
     * @return string
     */
    public function getTokenJson()
    {
        return '{"access_token":"eyJlbmMiOiJBMjU2R0NNIiwiYWxnIjoiUlNBMV81In0.U6n7ukU_06r9siXfEECaN08RFoqb7_256oSAUgd0ImkuxVTqKHI2sIFceTuyH7srNEBuJPURyjbxNy---zStkm5f61PiI24aybHe2SOHUeJZECaqaiGsFhe-crBsUIupOXVDskSj7Vf1EcjD2fOhM0df1_ynI0w2Q8QLH2pll65jHYqLfaMKiW2Je3Kj7LxQyybVVuPf6F3JvyN3K69GMiJ9ch87_u2pT9HdbeupiIPfrnQFJGR7KQtuhqLxJ_I7TtEZ1z28yfiGWWLXC41IaYALV2EyIpvomJhB6kybuFl-3CUvXUbz64TwuirkL-yxyb4xl4U73SwWuiyHaq8z9Q.56KSiq70iIPMuUiY.PUpfu6dlSv-SkuBtHMfnDfJGQxpq1tqn65bnpH6mN9OPhtBv0PumlOtRb-apqPu-rD2Z1VWfycXN5BjaV6-vEX2Trhz134sL5DBWaJavr3gRAUp6ssj9fgq0io1Z21jw1ILuD_LD5K0YaTU-rnKZY2oHpGI1Yx0Epx7oKFXa4RIcfY4oEIIfXFC-KlSBfIRxnTIrcZ88-9djfR6ZQaD26C9pYdqKJw7MIRVRYNhLiV77StuBx7PbgFpFo-UxiPNZ0oslw5QgPB2jRwWp8a1ecfwzttQKU1YYkBsvkpv6EgRaAIE11dCO8SyytXUWGcLAgR3FW6bOaXj18TKCkjftu3k_rHKHb48odUwU3EMOrmTpM9JgJ7aJjveQwe7GENzE8t2G2ObiwniK75Ise6pqu2pFqexszdTdRuT_2I1iSwHlmspNrZ3WH3biqTa5TdVObU30O172EW-CtxgTZNYH43EEr1McQijImTdBLw4abMrMTtaE1hK64bvmU7K94R6NdsQIO9SdB73__tBGyct6XHSplnZdRCVOMJm4CU-hfGtehg2Wld0jbCK2vQJ_GQ9DMkvTdw1vl-9BEy-8xdGAwp5hIhNUK6POpoNFqBDZDNpzmOugiTdYiuBl0rAFXs3Df2FVjk-fPBJKY5BfdQ0GVT9pMyQJU1XcO9q-XO-J55EylEuU6Nugvzb5kMUf74yMqqHizSnYKz2u1z7gR_aJzknUxSnulS9s8EJDDJOxItyGOc8gQVuah_0j7_-wJbi2n7SWS9vPJcs.j31RF27mdAZ0mBiqeKfFVA","token_type": "Bearer", "expires_in": 300}';
    }

    /**
     * @return string
     */
    public function getDeliverablityJson()
    {
        return file_get_contents(dirname(__FILE__) . '/when.json');
    }
}
