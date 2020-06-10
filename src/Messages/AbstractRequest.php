<?php

namespace Omnipay\Iyzico\Messages;

use Iyzipay\Model\Locale;
use Iyzipay\Options;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $liveEndpoint = 'https://api.iyzipay.com';
    protected $testEndpoint = 'https://sandbox-api.iyzipay.com';

    public function getOptions(): Options
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

    public function getBaseUrl(): string
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    public function setBaseUrl($baseUrl): AbstractRequest
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
        return $this->getParameter('paymentId');
    }

    /**
     * @param string $paymentId
     */
    public function setPaymentId(string $paymentId): void
    {
        $this->setParameter('paymentId', $paymentId);
    }

    /**
     * Get Local Code
     *
     * @return string
     */
    public function getLocale(): string
    {
        return !empty($this->getParameter('locale')) ? $this->getParameter('locale') : Locale::TR;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale): void
    {
        $this->setParameter('locale', $locale);
    }
}