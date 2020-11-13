<?php

namespace Omnipay\Iyzico\Messages;

use Iyzipay\Model\Payment;

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
        $response = new PurchaseResponse($this, Payment::create($data, $options));
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);


        return $response;
    }
}