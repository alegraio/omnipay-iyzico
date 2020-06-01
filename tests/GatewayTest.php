<?php

namespace Omnipay\Tests;

use Iyzipay\Model\Locale;
use Omnipay\Iyzico\IyzicoGateway;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var array
     */
    private $parameters;

    public function setUp()
    {
        /** @var IyzicoGateway gateway */
        $this->gateway = new IyzicoGateway(null, $this->getHttpRequest());
        $this->gateway->setApiKey('sandbox-xxxxx');
        $this->gateway->setSecretKey('sandbox-xxxxx');
        $this->gateway->setBaseUrl('https://sandbox-api.iyzipay.com');
    }

    public function testDeleteCard()
    {

    }

    public function testRefund()
    {

    }

    public function testAuthorize()
    {

    }

    public function testPurchase()
    {

    }

    public function testCreateCard()
    {

    }

    public function testPurchase3d()
    {

    }

    public function testPurchaseInfo()
    {

    }

    public function testAddCard()
    {

    }

    public function testGetCardList()
    {

    }

    public function testCancelPurchase()
    {

    }

    public function testInstallmentInfo()
    {
        $this->parameters = [
            'locale' => Locale::TR,
            'binNumber' => '554960',
            'price' => 100,
        ];

        $response = $this->gateway->installmentInfo($this->parameters)->send();
        var_dump($response);
    }
}
