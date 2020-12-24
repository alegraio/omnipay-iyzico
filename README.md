# omnipay-iyzico
<p>
<a href="https://github.com/alegraio/omnipay-iyzico/actions"><img src="https://github.com/alegraio/omnipay-iyzico/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/alegra/omnipay-iyzico"><img src="https://img.shields.io/packagist/dt/alegra/omnipay-iyzico" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/alegra/omnipay-iyzico"><img src="https://img.shields.io/packagist/v/alegra/omnipay-iyzico" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/alegra/omnipay-iyzico"><img src="https://img.shields.io/packagist/l/alegra/omnipay-iyzico" alt="License"></a>
</p>

Iyzico gateway for Omnipay V3 payment processing library

<a href="https://github.com/thephpleague/omnipay">Omnipay</a> is a framework agnostic, multi-gateway payment
processing library for PHP 7.3+. This package implements Iyzico Online Payment Gateway support for Omnipay.

<p>Iyzico API <a href="https://dev.iyzipay.com/en" rel="nofollow">documentation</a></p>

## Requirement

* PHP >= 7.3.x,
* [Omnipay V.3](https://github.com/thephpleague/omnipay) repository,
* PHPUnit to run tests

## Autoload

You have to install omnipay V.3

```bash
composer require league/omnipay:^3
```

Then you have to install omnipay-payu package:

```bash
composer require alegra/omnipay-iyzico
```

> `payment-iyzico` follows the PSR-4 convention names for its classes, which means you can easily integrate `payment-iyzico` classes loading in your own autoloader.

## Basic Usage

- You can use /examples folder to execute examples. This folder is exists here only to show you examples, it is not for production usage.
- First in /examples folder:

```bash
composer install
```

**Purchase Example**

- You can check purchase.php file in /examples folder.

```php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\Iyzico\IyzicoGateway;
use Examples\Helper;

$gateway = new IyzicoGateway();
$helper = new Helper();

try {
    $params = $helper->getPurchaseParams();
    $response = $gateway->purchase($params)->send();

    $result = [
        'status' => $response->isSuccessful() ?: 0,
        'redirect' => $response->isRedirect() ?: 0,
        'message' => $response->getMessage(),
        'transactionId' => $response->getTransactionReference(),
        'requestParams' => $response->getServiceRequestParams(),
        'response' => $response->getData()
    ];

    print("<pre>" . print_r($result, true) . "</pre>");
} catch (Exception $e) {
    throw new \RuntimeException($e->getMessage());
}
```

**Purchase 3d Example**

- You can check purchase3d.php file in /examples folder.

```php
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
```

**Complete Purchase Example**

- You can check completePurchase.php file in /examples folder.

```php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\Iyzico\IyzicoGateway;
use Examples\Helper;

$gateway = new IyzicoGateway();
$helper = new Helper();

try {
    $params = $helper->getCompletePurchaseParams();
    $response = $gateway->completePurchase($params)->send();

    $result = [
        'status' => $response->isSuccessful() ?: 0,
        'message' => $response->getMessage(),
        'transactionId' => $response->getTransactionReference(),
        'requestParams' => $response->getServiceRequestParams(),
        'response' => $response->getData()
    ];

    print("<pre>" . print_r($result, true) . "</pre>");
} catch (Exception $e) {
    throw new \RuntimeException($e->getMessage());
}
```

**Cancel Example**

- You can check cancel.php file in /examples folder.

```php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\Iyzico\IyzicoGateway;
use Examples\Helper;

$gateway = new IyzicoGateway();
$helper = new Helper();

try {
    $params = $helper->getCancelPurchaseParams();
    $response = $gateway->cancel($params)->send();

    $result = [
        'status' => $response->isSuccessful() ?: 0,
        'cancel' => $response->isCancelled() ?: 0,
        'message' => $response->getMessage(),
        'transactionId' => $response->getTransactionReference(),
        'requestParams' => $response->getServiceRequestParams(),
        'response' => $response->getData()
    ];

    print("<pre>" . print_r($result, true) . "</pre>");
} catch (Exception $e) {
    throw new \RuntimeException($e->getMessage());
}
```

**Refund Example**

- You can check refund.php file in /examples folder.

```php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\Iyzico\IyzicoGateway;
use Examples\Helper;

$gateway = new IyzicoGateway();
$helper = new Helper();

try {
    $params = $helper->getRefundParams();
    $response = $gateway->refund($params)->send();

    $result = [
        'status' => $response->isSuccessful() ?: 0,
        'message' => $response->getMessage(),
        'transactionId' => $response->getTransactionReference(),
        'requestParams' => $response->getServiceRequestParams(),
        'response' => $response->getData()
    ];

    print("<pre>" . print_r($result, true) . "</pre>");
} catch (Exception $e) {
    throw new \RuntimeException($e->getMessage());
}
```

**Purchase Transaction Detail Example**

- You can check purchaseInfo.php file in /examples folder.

```php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\Iyzico\IyzicoGateway;
use Examples\Helper;

$gateway = new IyzicoGateway();
$helper = new Helper();

try {
    $params = $helper->getPurchaseInfoParams();
    $response = $gateway->purchaseInfo($params)->send();

    $result = [
        'status' => $response->isSuccessful() ?: 0,
        'message' => $response->getMessage(),
        'transactionId' => $response->getTransactionReference(),
        'requestParams' => $response->getServiceRequestParams(),
        'response' => $response->getData()
    ];

    print("<pre>" . print_r($result, true) . "</pre>");
} catch (Exception $e) {
    throw new \RuntimeException($e->getMessage());
}
```

**Installment Detail Example**

- You can check installmentInfo.php file in /examples folder.

```php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\Iyzico\IyzicoGateway;
use Examples\Helper;

$gateway = new IyzicoGateway();
$helper = new Helper();

try {
    $params = $helper->getInstallmentInfoParams();
    $response = $gateway->installmentInfo($params)->send();

    $result = [
        'status' => $response->isSuccessful() ?: 0,
        'message' => $response->getMessage(),
        'transactionId' => $response->getTransactionReference(),
        'requestParams' => $response->getServiceRequestParams(),
        'response' => $response->getData()
    ];

    print("<pre>" . print_r($result, true) . "</pre>");
} catch (Exception $e) {
    throw new \RuntimeException($e->getMessage());
}
```

requestParams:

> System send request to Iyzico api. It shows request information.
>

## Licensing

[GNU General Public Licence v3.0](LICENSE)

    For the full copyright and license information, please view the LICENSE
    file that was distributed with this source code.