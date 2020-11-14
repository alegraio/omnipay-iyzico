<?php

namespace OmnipayTest\Iyzico\Messages;

use Omnipay\Iyzico\Messages\Purchase3dRequest;

class Purchase3dRequestTest extends IyzicoTestCase
{
    /**
     * @var Purchase3dRequest
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new Purchase3dRequest($this->getHttpClient(), $this->getHttpRequest());
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
        $this->setMockHttpResponse('Capture3DSuccess.txt');
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertTrue($response->isRedirect());
        self::assertNull($response->getMessage());
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