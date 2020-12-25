<?php

namespace Examples;

use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Locale;

class Helper
{

    /**
     * @return array
     */
    public function getPurchaseParams(): array
    {
        $params = $this->getDefaultPurchaseParams();
        $params['force3ds'] = '0';
        $params['amount'] = '10.00';

        return $params;
    }

    /**
     * @return array
     */
    public function getPurchase3dParams(): array
    {
        $params = $this->getDefaultPurchaseParams();
        $params['force3ds'] = '1';
        $params['amount'] = '10.00';
        $params['returnUrl'] = 'https://www.merchant.com/callback';

        return $params;
    }

    /**
     * @return array
     */
    public function getDefaultPurchaseParams(): array
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
                    'price' => '3.00'
                ],
                [
                    'id' => 'product2',
                    'name' => 'The Product 2',
                    'category1' => 'Main Category',
                    'category2' => 'Sub Category', // Optional
                    'itemType' => BasketItemType::VIRTUAL,
                    'price' => '7.00'
                ]
            ]
        ];

        return $this->provideMergedParams($params);
    }

    /**
     * @return array
     */
    public function getRefundParams(): array
    {
        $params = [
            'paymentTransactionId' => '12823076',
            'clientIp' => '11.11.11.111',
            'amount' => '10'
        ];

        return $this->provideMergedParams($params);
    }

    /**
     * @return array
     */
    public function getCancelPurchaseParams(): array
    {
        $params = [
            'paymentId' => '12678992',
            'clientIp' => '11.11.11.111'
        ];

        return $this->provideMergedParams($params);
    }

    /**
     * @return array
     */
    public function getCompletePurchaseParams(): array
    {
        $params = [
            'paymentId' => '13292709',
        ];

        return $this->provideMergedParams($params);
    }

    /**
     * @return array
     */
    public function getInstallmentInfoParams(): array
    {
        $params = [
            'locale' => Locale::TR,
            'binNumber' => '554960',
            'price' => 100,
        ];

        return $this->provideMergedParams($params);
    }

    /**
     * @return array
     */
    public function getPurchaseInfoParams(): array
    {
        $params = [
            'paymentId' => '12126832'
        ];

        return $this->provideMergedParams($params);
    }

    /**
     * @return array
     */
    private function getDefaultOptions(): array
    {
        return [
            'testMode' => true,
            'apiKey' => 'sandbox-hys5W0pF51uDgkjsYmvEZXtBWF0aF0gX',
            'secretKey' => 'sandbox-ZDHHKuo75gCWvgm1wZVfM1srsxRWQ3GZ',
        ];
    }

    /**
     * @param array $params
     * @return array
     */
    private function provideMergedParams(array $params): array
    {
        $params = array_merge($params, $this->getDefaultOptions());
        return $params;
    }

    /**
     * @return array
     */
    private function getValidCard(): array
    {
        return [
            'firstName' => 'Example',
            'lastName' => 'User',
            'number' => '5528790000000008',
            'expiryMonth' => '12',
            'expiryYear' => '2030',
            'cvv' => '123',
            'billingAddress1' => '123 Billing St',
            'billingAddress2' => 'Billsville',
            'billingCity' => 'Billstown',
            'billingPostcode' => '12345',
            'billingState' => 'CA',
            'billingCountry' => 'US',
            'billingPhone' => '(555) 123-4567',
            'shippingAddress1' => '123 Shipping St',
            'shippingAddress2' => 'Shipsville',
            'shippingCity' => 'Shipstown',
            'shippingPostcode' => '54321',
            'shippingState' => 'NY',
            'shippingCountry' => 'US',
            'shippingPhone' => '(555) 987-6543'
        ];
    }
}

