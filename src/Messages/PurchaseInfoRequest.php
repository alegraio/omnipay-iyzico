<?php

namespace Omnipay\Iyzico\Messages;

use Omnipay\Common\Exception\InvalidResponseException;
use Iyzipay\Model\Payment;
use Iyzipay\Request\RetrievePaymentRequest;
use Omnipay\Common\Message\ResponseInterface;

class PurchaseInfoRequest extends AbstractRequest
{
    /**
     * @return RetrievePaymentRequest
     */
    public function getData(): RetrievePaymentRequest
    {
        $request = new RetrievePaymentRequest();
        $request->setLocale($this->getLocale());
        $request->setPaymentId($this->getPaymentId());

        $this->setRequestParams($this->transformIyzicoRequest($request));

        return $request;
    }

    /**
     * @param mixed $data
     * @return ResponseInterface|PurchaseInfoResponse
     * @throws InvalidResponseException
     */
    public function sendData($data): PurchaseInfoResponse
    {
        try {
            $options = $this->getOptions();
            $response = new PurchaseInfoResponse($this, Payment::retrieve($data, $options));
            $requestParams = $this->getRequestParams();
            $response->setServiceRequestParams($requestParams);

            return $response;
        } catch (\Exception $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    public function getSensitiveData(): array
    {
        return [];
    }
}