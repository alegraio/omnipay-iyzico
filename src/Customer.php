<?php

namespace Omnipay\Iyzico;

use Omnipay\Common\Helper;
use Omnipay\Common\ParametersTrait;
use Symfony\Component\HttpFoundation\ParameterBag;

class Customer
{
    use ParametersTrait;

    /**
     * Create a new Customer object using the specified parameters
     *
     * @param array $parameters An array of parameters to set on the new object
     */
    public function __construct($parameters = null)
    {
        $this->initialize($parameters);
    }

    /**
     * Initialize the object with parameters.
     *
     * If any unknown parameters passed, they will be ignored.
     *
     * @param array $parameters An associative array of parameters
     * @return $this
     */
    public function initialize(array $parameters = null): self
    {
        $this->parameters = new ParameterBag;

        Helper::initialize($this, $parameters);

        return $this;
    }

    public function setClientId($value): Customer
    {
        return $this->setParameter('clientId', $value);
    }

    public function getClientId()
    {
        return $this->getParameter('clientId');
    }

    public function setClientName($value): Customer
    {
        return $this->setParameter('clientName', $value);
    }

    public function getClientName()
    {
        return $this->getParameter('clientName');
    }

    public function setClientSurName($value): Customer
    {
        return $this->setParameter('clientSurName', $value);
    }

    public function getClientSurName()
    {
        return $this->getParameter('clientSurName');
    }

    public function setClientCity($value): Customer
    {
        return $this->setParameter('clientCity', $value);
    }

    public function getClientCity()
    {
        return $this->getParameter('clientCity');
    }

    public function setClientCountry($value): Customer
    {
        return $this->setParameter('clientCountry', $value);
    }

    public function getClientCountry()
    {
        return $this->getParameter('clientCountry');
    }

    public function setClientAddress($value): Customer
    {
        return $this->setParameter('clientAddress', $value);
    }

    public function getClientAddress()
    {
        return $this->getParameter('clientAddress');
    }

    public function setClientEmail($value): Customer
    {
        return $this->setParameter('clientEmail', $value);
    }

    public function getClientEmail()
    {
        return $this->getParameter('clientEmail');
    }

    public function setClientPhone($value): Customer
    {
        return $this->setParameter('clientPhone', $value);
    }

    public function getClientPhone()
    {
        return $this->getParameter('clientPhone');
    }

    public function setLastLoginDate($value): Customer
    {
        return $this->setParameter('lastLoginDate', $value);
    }

    public function getLastLoginDate()
    {
        return $this->getParameter('lastLoginDate');
    }

    public function setRegistrationDate($value): Customer
    {
        return $this->setParameter('registrationDate', $value);
    }

    public function getRegistrationDate()
    {
        return $this->getParameter('registrationDate');
    }

    public function setRegistrationAddress($value): Customer
    {
        return $this->setParameter('registrationAddress', $value);
    }

    public function getRegistrationAddress()
    {
        return $this->getParameter('registrationAddress');
    }

    public function setPostcode($value): Customer
    {
        return $this->setParameter('postcode', $value);
    }

    public function getPostcode()
    {
        return $this->getParameter('postcode');
    }

    public function setIdentityNumber($value): Customer
    {
        return $this->setParameter('identityNumber', $value);
    }

    public function getIdentityNumber()
    {
        return $this->getParameter('identityNumber');
    }
}