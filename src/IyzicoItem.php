<?php

namespace Omnipay\Iyzico;

use Omnipay\Common\Item;

class IyzicoItem extends Item implements IyzicoItemInterface
{

    public function setId($id): IyzicoItem
    {
        return $this->setParameter('id', $id);
    }

    public function getId()
    {
        return $this->getParameter("id");
    }

    public function setCategory1($category1): IyzicoItem
    {
        return $this->setParameter('category1', $category1);
    }

    public function getCategory1()
    {
        return $this->getParameter("category1");
    }

    public function setCategory2($category2): IyzicoItem
    {
        return $this->setParameter('category2', $category2);
    }

    public function getCategory2()
    {
        return $this->getParameter("category2");
    }

    public function setItemType($itemType): IyzicoItem
    {
        return $this->setParameter('itemType', $itemType);
    }

    public function getItemType()
    {
        return $this->getParameter("itemType");
    }
}
