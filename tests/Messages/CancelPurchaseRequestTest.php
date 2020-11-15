<?php

namespace OmnipayTest\Iyzico\Messages;

use Omnipay\Iyzico\Messages\CancelPurchaseRequest;

class CancelPurchaseRequestTest extends IyzicoTestCase
{
    /**
     * @var $request CancelPurchaseRequest
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new CancelPurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getCancelPurchaseParams());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://sandbox-api.iyzipay.com', $this->request->getBaseUrl());
    }

    public function testData(): void
    {
        $data = $this->request->getData();
        self::assertSame('13292709', $data->getPaymentId());
        self::assertSame('11.11.11.111', $data->getIp());
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('CancelSuccess.txt');
        $response = $this->request->send();

        self::assertTrue($response->isCancelled());
        self::assertFalse($response->isRedirect());
        self::assertSame('https://sandbox-api.iyzipay.com/payment/cancel', $this->request->getIyzicoUrl());
        self::assertSame('12568377', $response->getTransactionReference());
        self::assertNull($response->getMessage());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('CancelFailure.txt');
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertSame('13292709', $response->getTransactionReference());
        self::assertSame('https://sandbox-api.iyzipay.com/payment/cancel', $this->request->getIyzicoUrl());
        self::assertSame('5086 : Üye işyerine ait ödeme kaydı bulunamadı', $response->getMessage());
    }
}