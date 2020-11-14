<?php

namespace Omnipay\Iyzico\Messages;

use Iyzipay\Model\ThreedsInitialize;
use Omnipay\Iyzico\IyzicoHttp;

class Purchase3dRequest extends AbstractRequest
{
    use PurchaseRequestTrait;

    public function getCallBackUrl(): ?string
    {
        return $this->getReturnUrl();
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        # make request
        $options = $this->getOptions();
        ThreedsInitialize::setHttpClient(new IyzicoHttp($this->httpClient));
        $response = new Purchase3dResponse($this, ThreedsInitialize::create($data, $options));
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }
}