<?php

namespace Omnipay\Tests;

use Exception;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Currency;
use Iyzipay\Model\Locale;
use Iyzipay\Model\PaymentChannel;
use Iyzipay\Model\PaymentGroup;
use Omnipay\Iyzico\IyzicoGateway;
use Omnipay\Iyzico\Messages\CancelPurchaseResponse;
use Omnipay\Iyzico\Messages\CompletePurchaseResponse;
use Omnipay\Iyzico\Messages\PurchaseInfoResponse;
use Omnipay\Iyzico\IyzicoItemBag;
use Omnipay\Iyzico\Messages\CardListResponse;
use Omnipay\Iyzico\Messages\InstallmentInfoResponse;
use Omnipay\Iyzico\Messages\Purchase3dResponse;
use Omnipay\Iyzico\Messages\PurchaseResponse;
use Omnipay\Iyzico\Messages\RefundResponse;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var array
     */
    private $parameters;

    /**
     * @var IyzicoGateway
     */
    protected $gateway;

    public function setUp()
    {
        /** @var IyzicoGateway gateway */
        $this->gateway = new IyzicoGateway(null, $this->getHttpRequest());
        $this->gateway->setParameter('testMode', true);
        $this->gateway->setApiKey('sandbox-hys5W0pF51uDgkjsYmvEZXtBWF0aF0gX');
        $this->gateway->setSecretKey('sandbox-ZDHHKuo75gCWvgm1wZVfM1srsxRWQ3GZ');
        // $this->gateway->setBaseUrl('https://sandbox-api.iyzipay.com');
    }

    public function testDeleteCard(): void
    {

    }

    public function testRefund(): void
    {
        $this->parameters = [
            'paymentTransactionId' => '12823076',
            'clientIp' => '11.11.11.111',
            'amount' => '10'
        ];

        /** @var RefundResponse $response */
        $response = $this->gateway->refund($this->parameters)->send();
        $this->assertTrue($response->isSuccessful());
    }

    public function testAuthorize(): void
    {

    }

    /**
     * @throws Exception
     */
    public function testPurchase(): void
    {
        $paymentCard = [
            'number' => '5170410000000004',
            'expiryMonth' => '12',
            'expiryYear' => '2030',
            'cvv' => '123',
            'email' => 'mail@mail.com',
            // Billing Information
            'billingPhone' => '(555) 555-555',
            'billingCity' => 'Istanbul',
            'billingCountry' => 'Turkey',
            'billingPostcode' => '34732',
            'billingFirstName' => 'John',
            'billingLastName' => 'Doe',
            'billingAddress1' => 'Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1',

            // Shipping Information
            'shippingPhone' => '(555) 555-555',
            'shippingCity' => 'Istanbul',
            'shippingCountry' => 'Turkey',
            'shippingPostcode' => '34732',
            'shippingFirstName' => 'John',
            'shippingLastName' => 'Doe',
            'shippingAddress1' => 'Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1',

        ];


        $items = [
            [
                'id' => 'product1',
                'name' => 'The Product 1',
                'category1' => 'Main Category',
                'category2' => 'Sub Category', // Optional
                'itemType' => BasketItemType::PHYSICAL,
                'price' => '0.3'
            ],
            [
                'id' => 'product2',
                'name' => 'The Product 2',
                'category1' => 'Main Category',
                'category2' => 'Sub Category', // Optional
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
            // 'force3ds' => '0',
            // '0' -> Purchase, '1' -> Purchase 3d, 'auto' -> Firstly Checks whether the credit card forces 3d payment, then make request for Purchase or 3d Purchase
            'returnUrl' => 'www.callback.com',
            // When force3ds is '1' or 'auto', Request will be 3d Purchase. So 'returnUrl' parameter must be in data of Request
            'price' => '1',
            'paidPrice' => '1.2',
            'currency' => Currency::TL,
            'installment' => 1,
            'basketId' => '123123123',
            // Optional -> Order Number Or Basket Id  etc. may be assigned
            'paymentChannel' => PaymentChannel::WEB,
            // Optional
            'paymentGroup' => PaymentGroup::PRODUCT,
            // Optional
            'card' => $paymentCard,
            'registerCard' => '0',
            // Optional
            'buyerId' => 'mail@mail.com',
            'identityNumber' => '11111111111',
            'clientIp' => '176.157.78.13',
            'items' => $basketItems

        ];

        /** @var PurchaseResponse $response */
        try {
            $response = $this->gateway->purchase($this->parameters)->send();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        $this->assertTrue($response->isSuccessful());
        // $this->assertArrayHasKey('orderId', $response->getRedirectData());
    }

    public function testCompletePurchase(): void
    {
        $this->parameters = [
            'locale' => Locale::TR, // Optional
            'paymentId' => '12126832'
            // 'conversationId' => '12341234', Optional
            // 'conversationData' => 'testdata' Optional
        ];

        /** @var CompletePurchaseResponse $response */
        $response = $this->gateway->completePurchase($this->parameters)->send();
        $this->assertTrue($response->isSuccessful());
    }

    public function testCreateCard(): void
    {

    }

    /**
     * @throws Exception
     */
    public function testPurchase3d(): void
    {
        $paymentCard = [
            'number' => '5170410000000004',
            'expiryMonth' => '12',
            'expiryYear' => '2030',
            'cvv' => '123',
            'email' => 'mail@mail.com',
            // Billing Information
            'billingPhone' => '(555) 555-555',
            'billingCity' => 'Istanbul',
            'billingCountry' => 'Turkey',
            'billingPostcode' => '34732',
            'billingFirstName' => 'John',
            'billingLastName' => 'Doe',
            'billingAddress1' => 'Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1',

            // Shipping Information
            'shippingPhone' => '(555) 555-555',
            'shippingCity' => 'Istanbul',
            'shippingCountry' => 'Turkey',
            'shippingPostcode' => '34732',
            'shippingFirstName' => 'John',
            'shippingLastName' => 'Doe',
            'shippingAddress1' => 'Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1',

        ];


        $items = [
            [
                'id' => 'product1',
                'name' => 'The Product 1',
                'category1' => 'Main Category',
                'category2' => 'Sub Category', // Optional
                'itemType' => BasketItemType::PHYSICAL,
                'price' => '0.3'
            ],
            [
                'id' => 'product2',
                'name' => 'The Product 2',
                'category1' => 'Main Category',
                'category2' => 'Sub Category', // Optional
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
            'force3ds' => '1',
            // '0' -> Purchase, '1' -> Purchase 3d, 'auto' -> Firstly Checks whether the credit card forces 3d payment, then make request for Purchase or 3d Purchase
            'returnUrl' => 'www.callback.com',
            // When force3ds is '1' or 'auto', Request will be 3d Purchase. So 'callbackUrl' parameter must be in data of Request
            'price' => '1',
            'paidPrice' => '1.2',
            'currency' => Currency::TL,
            'installment' => 1,
            'basketId' => '1231231567',
            // Optional -> Order Number Or Basket Id  etc. may be assigned
            'paymentChannel' => PaymentChannel::WEB,
            // Optional
            'paymentGroup' => PaymentGroup::PRODUCT,
            // Optional
            'card' => $paymentCard,
            'registerCard' => '0',
            // Optional
            'buyerId' => '123123123',
            'identityNumber' => '11111111111',
            'clientIp' => '176.157.78.56',
            'items' => $basketItems

        ];

        /** @var Purchase3dResponse $response */
        try {
            $response = $this->gateway->purchase($this->parameters)->send();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        // $redirectData = $response->getRedirectData();
        // $redirectUrl = $response->getRedirectUrl();
        // $threeDHtmlContent = $response->getThreeDHtmlContent();
        $this->assertTrue($response->isSuccessful());
        $this->assertArrayHasKey('orderId', $response->getRedirectData());
    }

    public function testPurchaseInfo(): void
    {
        $this->parameters = [
            'paymentId' => '12126832'
        ];

        /** @var PurchaseInfoResponse $response */
        $response = $this->gateway->purchaseInfo($this->parameters)->send();
        $this->assertTrue($response->isSuccessful());
    }


    public function testAddCard(): void
    {

    }

    public function testGetCardList(): void
    {
        $this->parameters = [
            'locale' => Locale::TR,
            'cardUserKey' => 'card user key'
        ];

        /** @var CardListResponse $response */
        $response = $this->gateway->getCardList($this->parameters)->send();
        $this->assertTrue($response->isSuccessful());
    }

    public function testCancelPurchase(): void
    {
        $this->parameters = [
            'paymentId' => '12126832',
            'clientIp' => '11.11.11.111'
        ];

        /** @var CancelPurchaseResponse $response */
        $response = $this->gateway->cancelPurchase($this->parameters)->send();
        $this->assertTrue($response->isSuccessful());
    }

    public function testInstallmentInfo(): void
    {
        $this->parameters = [
            'locale' => Locale::TR,
            'binNumber' => '552608',
            'price' => 100
        ];

        /** @var InstallmentInfoResponse $response */
        $response = $this->gateway->installmentInfo($this->parameters)->send();
        $this->assertTrue($response->isSuccessful());
    }

    public function testCallBackUrl(): void
    {
        $callBackUrlPostData = [
            'status' => 'success',
            'paymentId' => '12130103',
            'conversationData' => null, // Should be send to Complete Purchase Request when it is not empty or not null
            'conversationId' => '83ec2b9686168e1747beb624ef607a264a23437b',
            'mdStatus' => 1
        ];
        if ($callBackUrlPostData['status'] === 'success' && $callBackUrlPostData['mdStatus'] === 1) { // Status must be 'success' and also 'mdStatus' must be 1 to make complete Purchase Request
            $this->parameters = [
                'locale' => Locale::TR, // Optional
                'paymentId' => $callBackUrlPostData['paymentId']
            ];

            if (!empty($callBackUrlPostData['conversationData'])) {
                $this->parameters['conversationData'] = $callBackUrlPostData['conversationData'];
            }

            /** @var CompletePurchaseResponse $response */
            $response = $this->gateway->completePurchase($this->parameters)->send();
            $this->assertTrue($response->isSuccessful());
        }
    }
}
