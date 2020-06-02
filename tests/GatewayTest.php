<?php

namespace Omnipay\Tests;

use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Currency;
use Iyzipay\Model\Locale;
use Iyzipay\Model\PaymentChannel;
use Iyzipay\Model\PaymentGroup;
use Omnipay\Common\CreditCard;
use Omnipay\Iyzico\IyzicoGateway;
use Omnipay\Iyzico\IyzicoItemBag;
use Omnipay\Iyzico\Messages\Purchase3dResponse;
use Omnipay\Iyzico\Messages\PurchaseResponse;

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
        $paymentCard = new CreditCard();
        $paymentCard->setNumber("5170410000000004");
        $paymentCard->setExpiryMonth("12");
        $paymentCard->setExpiryYear("2030");
        $paymentCard->setCvv("123");
        $paymentCard->setEmail("mail@mail.com");
        $paymentCard->setPhone("(555) 555-555");
        $paymentCard->setCity("Istanbul");
        $paymentCard->setCountry("Turkey");
        $paymentCard->setPostcode("34732");

        // Shipping
        $paymentCard->setShippingName("John Doe");
        $paymentCard->setShippingCity("Istanbul");
        $paymentCard->setShippingCountry("Turkey");
        $paymentCard->setShippingAddress1("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $paymentCard->setShippingPostcode("34732");

        // Billing
        $paymentCard->setBillingName("John Doe");
        $paymentCard->setBillingCity("Istanbul");
        $paymentCard->setBillingCountry("Turkey");
        $paymentCard->setBillingAddress1("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $paymentCard->setBillingPostcode("34732");


        $items = [
            [
                'id' => 'product1',
                'name' => 'The Product 1',
                'category1' => 'Main Category',
                'category2' => "Sub Category", // Optional
                'itemType' => BasketItemType::PHYSICAL,
                'price' => '0.3'
            ],
            [
                'id' => 'product2',
                'name' => 'The Product 2',
                'category1' => 'Main Category',
                'category2' => "Sub Category", // Optional
                'itemType' => BasketItemType::VIRTUAL,
                'price' => '0.7'
            ]
        ];

        $basketItems = new IyzicoItemBag();
        foreach ($items as $item) {
            $basketItems->add($item);
        }

        $this->parameters = [
            'locale' => Locale::TR,
            'force3ds' => '0', // '0' -> Purchase, '1' -> Purchase 3d, 'auto' -> Firstly Checks whether the credit card forces 3d payment, then make request for Purchase or 3d Purchase
            'callbackUrl' => 'www.callback.com', // When force3ds is '1' or 'auto', Request will be 3d Purchase. So 'callbackUrl' parameter must be in data of Request
            'price' => "1",
            'paidPrice' => "1.2",
            'currency' => Currency::TL,
            'installment' => 1,
            'basketId' => "123123123", // Optional -> Order Number Or Basket Id  etc. may be assigned
            'paymentChannel' => PaymentChannel::WEB, // Optional
            'paymentGroup' => PaymentGroup::PRODUCT, // Optional
            'card' => $paymentCard,
            'registerCard' => "0", // Optional
            'buyerId' => "123123123",
            'identityNumber' => "11111111111",
            'clientIp' => '176.157.78.13',
            'items' => $basketItems

        ];

        /** @var PurchaseResponse $response */
        $response = $this->gateway->purchase($this->parameters)->send();
        $this->assertTrue($response->isSuccessful());
    }

    public function testCompletePurchase()
    {

    }

    public function testCreateCard()
    {

    }

    public function testPurchase3d()
    {
        $paymentCard = new CreditCard();
        $paymentCard->setNumber("5170410000000004");
        $paymentCard->setExpiryMonth("12");
        $paymentCard->setExpiryYear("2030");
        $paymentCard->setCvv("123");
        $paymentCard->setEmail("mail@mail.com");
        $paymentCard->setPhone("(555) 555-555");
        $paymentCard->setCity("Istanbul");
        $paymentCard->setCountry("Turkey");
        $paymentCard->setPostcode("34732");

        // Shipping
        $paymentCard->setShippingName("John Doe");
        $paymentCard->setShippingCity("Istanbul");
        $paymentCard->setShippingCountry("Turkey");
        $paymentCard->setShippingAddress1("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $paymentCard->setShippingPostcode("34732");

        // Billing
        $paymentCard->setBillingName("John Doe");
        $paymentCard->setBillingCity("Istanbul");
        $paymentCard->setBillingCountry("Turkey");
        $paymentCard->setBillingAddress1("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $paymentCard->setBillingPostcode("34732");


        $items = [
            [
                'id' => 'product1',
                'name' => 'The Product 1',
                'category1' => 'Main Category',
                'category2' => "Sub Category", // Optional
                'itemType' => BasketItemType::PHYSICAL,
                'price' => '0.3'
            ],
            [
                'id' => 'product2',
                'name' => 'The Product 2',
                'category1' => 'Main Category',
                'category2' => "Sub Category", // Optional
                'itemType' => BasketItemType::VIRTUAL,
                'price' => '0.7'
            ]
        ];

        $basketItems = new IyzicoItemBag();
        foreach ($items as $item) {
            $basketItems->add($item);
        }

        $this->parameters = [
            'locale' => Locale::TR,
            'force3ds' => '1', // '0' -> Purchase, '1' -> Purchase 3d, 'auto' -> Firstly Checks whether the credit card forces 3d payment, then make request for Purchase or 3d Purchase
            'returnUrl' => 'www.callback.com', // When force3ds is '1' or 'auto', Request will be 3d Purchase. So 'callbackUrl' parameter must be in data of Request
            'price' => "1",
            'paidPrice' => "1.2",
            'currency' => Currency::TL,
            'installment' => 1,
            'basketId' => "1231231567", // Optional -> Order Number Or Basket Id  etc. may be assigned
            'paymentChannel' => PaymentChannel::WEB, // Optional
            'paymentGroup' => PaymentGroup::PRODUCT, // Optional
            'card' => $paymentCard,
            'registerCard' => "0", // Optional
            'buyerId' => "123123123",
            'identityNumber' => "11111111111",
            'clientIp' => '176.157.78.56',
            'items' => $basketItems

        ];

        /** @var Purchase3dResponse $response */
        $response = $this->gateway->purchase($this->parameters)->send();
        $this->assertTrue($response->isSuccessful());
    }

    public function testPurchaseInfo()
    {

    }

    public function testAddCard()
    {

    }

    public function testGetCardList()
    {
        $this->parameters = [
            'locale' => Locale::TR,
            'cardUserKey' => 'card user key'
        ];

        $response = $this->gateway->getCardList($this->parameters)->send();
        var_dump($response);
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
