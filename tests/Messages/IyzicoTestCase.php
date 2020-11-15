<?php

namespace OmnipayTest\Iyzico\Messages;

use Iyzipay\Model\BasketItemType;
use Omnipay\Tests\TestCase;

class IyzicoTestCase extends TestCase
{
    protected function getPurchaseParams(): array
    {
        $params = [
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

        return $this->provideMergedParams($params);
    }

    protected function getRefundParams(): array
    {
        $params = [
            'paymentTransactionId' => '12823076',
            'clientIp' => '11.11.11.111',
            'amount' => '10'
        ];

        return $this->provideMergedParams($params);
    }

    protected function getCancelPurchaseParams(): array
    {
        $params = [
            'paymentId' => '13292709',
            'clientIp' => '11.11.11.111'
        ];

        return $this->provideMergedParams($params);
    }

    protected function getCompletePurchaseParams(): array
    {
        $params = [
            'paymentId' => '13292709',
        ];

        return $this->provideMergedParams($params);
    }

    private function getDefaultOptions(): array
    {
        return [
            'testMode' => true,
            'apiKey' => 'sandbox-hys5W0pF51uDgkjsYmvEZXtBWF0aF0gX',
            'secretKey' => 'sandbox-ZDHHKuo75gCWvgm1wZVfM1srsxRWQ3GZ',
        ];
    }

    private function provideMergedParams($params): array
    {
        $params = array_merge($params, $this->getDefaultOptions());
        return $params;
    }
}