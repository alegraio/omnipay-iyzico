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
        $data = $this->transformIyzicoRequest($data);
        $response->setServiceRequestParams($data);

        return $response;
    }
}