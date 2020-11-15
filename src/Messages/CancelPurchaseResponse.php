<?php

namespace Omnipay\Iyzico\Messages;

class CancelPurchaseResponse extends AbstractResponse
{
    /**
     * @inheritdoc
     */
    public function isCancelled(): bool
    {
        return !('success' !== $this->getResponse()->getStatus());
    }
}