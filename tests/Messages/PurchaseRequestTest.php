<?php

namespace OmnipayTest\Iyzico\Messages;

use Omnipay\Iyzico\Messages\PurchaseRequest;

class PurchaseRequestTest extends IyzicoTestCase
{
    /**
     * @var PurchaseRequest
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getPurchaseParams());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://sandbox-api.iyzipay.com', $this->request->getBaseUrl());
    }

    public function testAmount(): void
    {
        // default is no amount
        self::assertArrayNotHasKey('amount', $this->request->transformIyzicoRequest($this->request->getData()));

        $this->request->setAmount('10.00');

        $data = $this->request->getData();
        self::assertSame('10.00', $data->getPrice());
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('CaptureSuccess.txt');
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertFalse($response->isRedirect());
        self::assertNull($response->getMessage());
        self::assertSame('12567302', $response->getTransactionReference());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('CaptureFailure.txt');
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertFalse($response->isRedirect());
        self::assertNull($response->getTransactionReference());
        self::assertSame('12 : Kart numarası geçersizdir', $response->getMessage());
    }
}