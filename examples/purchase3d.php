<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\Iyzico\IyzicoGateway;
use Examples\Helper;

$gateway = new IyzicoGateway();
$helper = new Helper();

try {
    $params = $helper->getPurchase3dParams();
    $response = $gateway->purchase($params)->send();

    $result = [
        'status' => $response->isSuccessful() ?: 0,
        'redirect' => $response->isRedirect() ?: 0,
        'redirectUrl' => $response->getRedirectUrl() ?: null,
        'redirectData' => $response->getRedirectData(),
        'htmlData' => $response->getThreeDHtmlContent(),
        'message' => $response->getMessage(),
        'transactionId' => $response->getTransactionReference(),
        'requestParams' => $response->getServiceRequestParams(),
        'response' => $response->getData()
    ];

    print("<pre>" . print_r($result, true) . "</pre>");
} catch (Exception $e) {
    throw new \RuntimeException($e->getMessage());
}
