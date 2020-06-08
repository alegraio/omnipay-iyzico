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
        return new PurchaseResponse($this, Payment::create($data, $options));
    }


}