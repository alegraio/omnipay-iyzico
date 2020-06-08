<?php

namespace Omnipay\Iyzico\Messages;

use Iyzipay\Model\ThreedsInitialize;

class Purchase3dRequest extends AbstractRequest
{
    use PurchaseRequestTrait;

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        # make request
        $options = $this->getOptions();
        return new Purchase3dResponse($this, ThreedsInitialize::create($data, $options));
    }
}