<?php

namespace Omnipay\Iyzico;

use Omnipay\Common\CreditCard;

class Card extends CreditCard
{

    /**
     * Set Card First Name (Billing, Shipping and Card holder).
     *
     * @param string $value Parameter value
     * @return $this
     */
    public function setFirstName($value)
    {
        $this->setBillingFirstName($value);
        $this->setShippingFirstName($value);
        $this->setCardHolderFirstName($value);

        return $this;
    }

    /**
     * Set Card Last Name (Billing, Shipping and Card holder).
     *
     * @param string $value Parameter value
     * @return $this
     */
    public function setLastName($value)
    {
        $this->setBillingLastName($value);
        $this->setShippingLastName($value);
        $this->setCardHolderLastName($value);

        return $this;
    }

    /**
     * Get card holder first name.
     *
     * @return string
     */
    public function getCardHolderFirstName()
    {
        return $this->getParameter('firstName');
    }

    /**
     * Sets card holder first name.
     *
     * @param string $value
     * @return $this
     */
    public function setCardHolderFirstName($value)
    {
        return $this->setParameter('firstName', $value);
    }

    /**
     * Get card holder last name.
     *
     * @return string
     */
    public function getCardHolderLastName()
    {
        return $this->getParameter('lastName');
    }

    /**
     * Sets card holder last name.
     *
     * @param string $value
     * @return $this
     */
    public function setCardHolderLastName($value)
    {
        return $this->setParameter('lastName', $value);
    }


    /**
     * Get the card holder name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getCardHolderName();
    }

    /**
     * Get the card holder name.
     *
     * @return string
     */
    public function getCardHolderName()
    {
        return trim($this->getCardHolderFirstName() . ' ' . $this->getCardHolderLastName());
    }

}