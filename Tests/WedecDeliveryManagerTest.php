<?php


namespace GoDoItBundle\Tests\Delivery\WedecDeliveryBundle;


use GoDoItBundle\Delivery\WedecDeliveryBundle\WedecDeliveryManager;
use Psr\Http\Message\RequestInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WedecDeliveryClientTest extends WebTestCase
{

    /**
     * @var WedecDeliveryManager
     */
    protected $manager;

    protected function setUp()
    {
        // he hates himself for doing this
        $kernel = static::createKernel();
        $kernel->boot();

        $this->manager = $kernel->getContainer()->get('app.delivery.wedec_delivery_manager');
    }

    public function testCreation()
    {
        $this->assertNotNull($this->manager);
        $this->assertSame('05d5ca3586ec9a345821620e7f052577', $this->manager->getClientId());
        $this->assertSame('ffb7e3505a7d670169fc1ed7539a180e', $this->manager->getClientSecret());
        $this->assertSame('https://wedec.post.ch', $this->manager->getBaseUri());
    }

    public function testOAuthRequest()
    {
        $request = $this->manager->getOAuthRequest();

        $this->assertNotNull($request);
        $this->assertInstanceOf(RequestInterface::class, $request);

        $this->assertSame('POST', $request->getMethod());

        $uriQuery = 'grant_type=client_credentials&client_id=05d5ca3586ec9a345821620e7f052577&client_secret=ffb7e3505a7d670169fc1ed7539a180e&scope=WEDEC_DELIVERY';
        $this->assertNotNull($request->getUri());
        $this->assertSame('wedec.post.ch', $request->getUri()->getHost());
        $this->assertSame('/WEDECOAuth/authorization', $request->getUri()->getPath());
        $this->assertSame($uriQuery, $request->getUri()->getQuery());
        $this->assertNotNull($request->getHeaders());
    }

    public function tearDown()
    {
        $this->manager = null;
        parent::tearDown();
    }
}
