<?php

namespace OmnipayTest\Iyzico\Messages;

use Omnipay\Iyzico\Messages\CompletePurchaseRequest;

class CompletePurchaseRequestTest extends IyzicoTestCase
{
    /**
     * @var $request CompletePurchaseRequest
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getCompletePurchaseParams());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://sandbox-api.iyzipay.com', $this->request->getBaseUrl());
    }

    public function testData(): void
    {
        $data = $this->request->getData();
        self::assertSame('13292709', $data->getPaymentId());
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('CompletePurchaseSuccess.txt');
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertFalse($response->isRedirect());
        self::assertSame('https://sandbox-api.iyzipay.com/payment/3dsecure/auth', $this->request->getIyzicoUrl());
        self::assertSame('12568440', $response->getTransactionReference());
        self::assertNull($response->getMessage());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('CompletePurchaseFailure.txt');
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertNull($response->getTransactionReference());
        self::assertSame('https://sandbox-api.iyzipay.com/payment/3dsecure/auth', $this->request->getIyzicoUrl());
        self::assertSame('5115', $response->getCode());
        self::assertSame('Bu ödemenin durumu 3dsecure için geçerli değil', $response->getMessage());
    }
}