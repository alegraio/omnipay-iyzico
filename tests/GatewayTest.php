<?php

namespace Omnipay\Tests;

use Omnipay\Iyzico\IyzicoGateway;
use PHPUnit\Framework\TestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        /** @var IyzicoGateway gateway */
        $this->gateway = new IyzicoGateway(null, $this->getHttpRequest());
        $this->gateway->setApiKey('API_KEY');
        $this->gateway->setApiSecret('API_SECRET');
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

    }
}
