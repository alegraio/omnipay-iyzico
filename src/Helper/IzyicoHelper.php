<?php
namespace Omnipay\Iyzico\Helper;

class IzyicoHelper
{
    public static function createUniqueID(string $prefix = ''): string
    {
        return uniqid($prefix, true);
    }
}