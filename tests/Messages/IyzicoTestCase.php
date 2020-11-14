<?php

namespace OmnipayTest\Iyzico\Messages;

use Iyzipay\Model\BasketItemType;
use Omnipay\Tests\TestCase;

class IyzicoTestCase extends TestCase
{
    protected function getPurchaseParams(): array
    {
        return [
            'testMode' => true,
            'apiKey' => 'sandbox-hys5W0pF51uDgkjsYmvEZXtBWF0aF0gX',
            'secretKey' => 'sandbox-ZDHHKuo75gCWvgm1wZVfM1srsxRWQ3GZ',
            'card' => $this->getValidCard(),
            'customer' => [
                'clientId' => '23645',
                'clientName' => 'John',
                'clientSurName' => 'Doe',
                'clientCity' => 'Istanbul',
                'clientCountry' => 'Turkey',
                'identityNumber' => '11111111111',
                'clientAddress' => 'Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1',
                'clientEmail' => 'mail@mail.com'
            ],
            'items' => [
                [
                    'id' => 'product1',
                    'name' => 'The Product 1',
                    'category1' => 'Main Category',
                    'category2' => 'Sub Category', // Optional
                    'itemType' => BasketItemType::PHYSICAL,
                    'price' => '0.3'
                ],
                [
                    'id' => 'product2',
                    'name' => 'The Product 2',
                    'category1' => 'Main Category',
                    'category2' => 'Sub Category', // Optional
                    'itemType' => BasketItemType::VIRTUAL,
                    'price' => '0.7'
                ]
            ]
        ];
    }
}