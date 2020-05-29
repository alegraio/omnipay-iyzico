<?php


namespace Omnipay\Iyzico\Messages;


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
}