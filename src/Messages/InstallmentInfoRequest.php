<?php

namespace Omnipay\Iyzico\Messages;

use Iyzipay\Model\InstallmentInfo;
use Iyzipay\Model\Locale;
use Iyzipay\Request\RetrieveInstallmentInfoRequest;

class InstallmentInfoRequest extends AbstractRequest
{
    public function setLocale($locale)
    {
        $this->setParameter("locale", $locale);
    }
    public function setBinNumber($binNumber)
    {
        $this->setParameter("binNumber", $binNumber);
    }
    public function setPrice($price)
    {
        $this->setParameter("price", $price);
    }
    public function getLocale()
    {
        return !empty($this->getParameter("locale")) ? $this->getParameter("locale") : Locale::TR;
    }

    public function getBinNumber()
    {
        return $this->getParameter("binNumber");
    }

    public function getPrice()
    {
        return $this->getParameter("price");
    }

    public function buildTransactionID()
    {
        $data = array(
            "locale" => $this->getLocale(),
            "binNumber" => $this->getBinNumber(),
            "price" => $this->getPrice(),
            "id" => uniqid(),
            "timestamp" => date("YmdHis")
        );
        $data = serialize($data);
        return hash_hmac("sha1", $data, $this->getSecretKey());
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {

        $request = new RetrieveInstallmentInfoRequest();
        $request->setLocale($this->getLocale());
        $request->setConversationId($this->buildTransactionID());
        $request->setBinNumber($this->getBinNumber());
        $request->setPrice($this->getPrice());

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        $options = $this->getOptions();
        return new InstallmentInfoResponse($this, InstallmentInfo::retrieve($data, $options));
    }
}