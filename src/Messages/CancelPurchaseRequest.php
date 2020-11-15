<?php

namespace Omnipay\Iyzico\Messages;

use Iyzipay\Model\Cancel;
use Iyzipay\Request\CreateCancelRequest;
use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Iyzico\IyzicoHttp;

class CancelPurchaseRequest extends AbstractRequest
{
    /**
     * @return CreateCancelRequest
     */
    public function getData(): CreateCancelRequest
    {
        $request = new CreateCancelRequest();
        $request->setLocale($this->getLocale());
        $request->setPaymentId($this->getPaymentId());
        $request->setIp($this->getClientIp());

        $this->setRequestParams($this->transformIyzicoRequest($request));

        return $request;
    }

    /**
     * @param mixed $data
     * @return ResponseInterface|CancelPurchaseResponse
     * @throws InvalidResponseException
     */
    public function sendData($data): CancelPurchaseResponse
    {
        try {
            $options = $this->getOptions();
            Cancel::setHttpClient(new IyzicoHttp($this->httpClient));
            $response = new CancelPurchaseResponse($this, Cancel::create($data, $options));
            /**
             * @var $client IyzicoHttp
             */
            $client = Cancel::httpClient();
            $this->setIyzicoUrl($client->getUrl());
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