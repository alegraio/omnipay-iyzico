<?php

namespace Omnipay\Iyzico;

interface IyzicoRequestInterface
{
    public function getSensitiveData(): array;
}