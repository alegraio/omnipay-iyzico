<?php


namespace Omnipay\Iyzico\Messages;

use Iyzipay\Model\Locale;
use Iyzipay\Options;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{

    public function getOptions()
    {
        $options = new Options();
        $options->setApiKey($this->getApiKey());
        $options->setSecretKey($this->getSecretKey());
        $options->setBaseUrl($this->getBaseUrl());

        return $options;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    public function getBaseUrl()
    {
        return $this->getParameter("baseUrl");
    }

    public function setBaseUrl($baseUrl)
    {
        return $this->setParameter('baseUrl', $baseUrl);
    }

    /**
     * Get Iyzico payment Id
     *
     * @return string
     */
    public function getPaymentId(): string
    {
        return $this->getParameter("paymentId");
    }

    /**
     * @param string $paymentId
     */
    public function setPaymentId(string $paymentId)
    {
        $this->setParameter("paymentId", $paymentId);
    }

    /**
     * Get Local Code
     *
     * @return string
     */
    public function getLocale(): string
    {
        return !empty($this->getParameter("locale")) ? $this->getParameter("locale") : Locale::TR;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale)
    {
        $this->setParameter("locale", $locale);
    }
}