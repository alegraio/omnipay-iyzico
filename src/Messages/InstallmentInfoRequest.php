<?php

namespace Omnipay\Iyzico\Messages;

use Iyzipay\Model\InstallmentInfo;
use Iyzipay\Request\RetrieveInstallmentInfoRequest;
use Omnipay\Iyzico\IyzicoHttp;

class InstallmentInfoRequest extends AbstractRequest
{
    use PurchaseRequestTrait;

    public function setBinNumber($binNumber): void
    {
        $this->setParameter('binNumber', $binNumber);
    }

    public function setPrice($price): void
    {
        $this->setParameter('price', $price);
    }

    public function getBinNumber()
    {
        return $this->getParameter('binNumber');
    }

    public function getPrice()
    {
        return $this->getParameter('price');
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {

        $request = new RetrieveInstallmentInfoRequest();
        $request->setLocale($this->getLocale());
        $request->setConversationId($this->getConversationId());
        $request->setBinNumber($this->getBinNumber());
        $request->setPrice($this->getPrice());

        $this->setRequestParams($this->transformIyzicoRequest($request));

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        $options = $this->getOptions();
        InstallmentInfo::setHttpClient(new IyzicoHttp($this->httpClient));
        $response = new InstallmentInfoResponse($this, InstallmentInfo::retrieve($data, $options));
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }

    public function getSensitiveData(): array
    {
        return ['binNumber'];
    }
}