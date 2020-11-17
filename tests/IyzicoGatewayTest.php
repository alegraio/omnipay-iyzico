<?php

namespace OmnipayTest\Iyzico;

use Omnipay\Common\Message\RequestInterface;
use Omnipay\Iyzico\IyzicoGateway;
use Omnipay\Iyzico\Messages\AuthorizeRequest;
use Omnipay\Iyzico\Messages\CompletePurchaseRequest;
use Omnipay\Iyzico\Messages\Purchase3dRequest;
use Omnipay\Iyzico\Messages\PurchaseRequest;
use Omnipay\Tests\GatewayTestCase;

class IyzicoGatewayTest extends GatewayTestCase
{
    public function setUp(): void
    {
        $this->gateway = new IyzicoGateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testSupportsPurchase(): void
    {
        $supportsPurchase = $this->gateway->supportsPurchase();
        self::assertInternalType('boolean', $supportsPurchase);

        if ($supportsPurchase) {
            self::assertInstanceOf(RequestInterface::class,
                $this->gateway->purchase(['force3ds' => '0']));
        } else {
            self::assertFalse(method_exists($this->gateway, 'purchase'));
        }
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testPurchaseParameters(): void
    {
        if ($this->gateway->supportsPurchase()) {
            foreach ($this->gateway->getDefaultParameters() as $key => $default) {
                // set property on gateway
                $getter = 'get' . ucfirst($this->camelCase($key));
                $setter = 'set' . ucfirst($this->camelCase($key));
                $value = uniqid('', false);
                $this->gateway->$setter($value);

                // request should have matching property, with correct value
                $request = $this->gateway->purchase(['force3ds' => '0']);
                self::assertSame($value, $request->$getter());
            }
        }
    }

    public function testAuthorize(): void
    {
        $request = $this->gateway->authorize(['amount' => '10.00']);

        self::assertInstanceOf(AuthorizeRequest::class, $request);
        self::assertSame('10.00', $request->getAmount());
    }

    public function testPurchase(): void
    {
        $request = $this->gateway->purchase(['force3ds' => '0', 'amount' => '10.00']);

        self::assertInstanceOf(PurchaseRequest::class, $request);
        self::assertSame('10.00', $request->getAmount());
    }

    public function testPurchase3D(): void
    {
        $request = $this->gateway->purchase(['force3ds' => '1', 'amount' => '10.00']);

        self::assertInstanceOf(Purchase3dRequest::class, $request);
        self::assertSame('10.00', $request->getAmount());
    }

    public function testCompletePurchase(): void
    {
        $request = $this->gateway->completePurchase(['paymentId' => '12568440']);

        self::assertInstanceOf(CompletePurchaseRequest::class, $request);
        self::assertSame('12568440', $request->getPaymentId());
    }
}