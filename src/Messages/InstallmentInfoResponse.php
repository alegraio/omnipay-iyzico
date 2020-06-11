<?php

namespace Omnipay\Iyzico\Messages;

class InstallmentInfoResponse extends AbstractResponse
{
    public function getData()
    {
        return $this->getResponse();
    }
}