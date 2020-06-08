<?php

namespace Omnipay\Iyzico;

use Omnipay\Common\ItemBag;
use Omnipay\Common\ItemInterface;

class IyzicoItemBag extends ItemBag
{
    /**
     * Add an item to the bag
     *
     * @param ItemInterface|array $item An existing item, or associative array of item parameters
     * @see Item
     *
     */
    public function add($item): void
    {
        if ($item instanceof ItemInterface) {
            $this->items[] = $item;
        } else {
            $this->items[] = new IyzicoItem($item);
        }
    }

    /**
     * @return ItemInterface|array
     */
    public function getItems()
    {
        return $this->items;
    }

}
