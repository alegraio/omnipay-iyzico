<?php

namespace Omnipay\Iyzico;

use Omnipay\Common\Item;

class IyzicoItem extends Item implements IyzicoItemInterface
{
    /**
     * Set the sku
     * @param $value
     * @return IyzicoItem
     */
    public function setSku($value)
    {
        return $this->setParameter('sku', $value);
    }

    public function getSku()
    {
        return $this->getParameter('sku');
    }

    public function getVat()
    {
        return (!empty($this->getParameter('vat'))) ? $this->getParameter('vat') : '18';
    }

    public function setVat($value)
    {
        return $this->setParameter('vat', $value);
    }

}
