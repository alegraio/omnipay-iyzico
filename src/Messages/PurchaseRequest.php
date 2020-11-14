<?php

namespace Omnipay\Iyzico\Messages;

use Iyzipay\Model\Payment;
use Omnipay\Iyzico\IyzicoHttp;

class PurchaseRequest extends AbstractRequest
{
    use PurchaseRequestTrait;

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        # make request
        $options = $this->getOptions();
        Payment::setHttpClient(new IyzicoHttp($this->httpClient));
        $response = new PurchaseResponse($this, Payment::create($data, $options));
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);


        return $response;
    }
}