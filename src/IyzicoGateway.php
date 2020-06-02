<?php
/**
 * Iyzico Class using API
 */

namespace Omnipay\Iyzico;

use Exception;
use Iyzipay\Model\Locale;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;


/**
 * @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface fetchTransaction(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
 */
class IyzicoGateway extends AbstractGateway
{

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'Iyzico';
    }

    public function getApiKey()
    {
        return $this->getParameter("apiKey");
    }

    public function getSecretKey()
    {
        return $this->getParameter("secretKey");
    }

    public function getBaseUrl()
    {
        return $this->getParameter("baseUrl");
    }

    public function setApiKey($apiKey)
    {
        return $this->setParameter('apiKey', $apiKey);
    }

    public function setSecretKey($apiSecret)
    {
        return $this->setParameter('secretKey', $apiSecret);
    }

    public function setBaseUrl($baseUrl)
    {
        return $this->setParameter('baseUrl', $baseUrl);
    }

    /**
     * @inheritDoc
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Messages\AuthorizeRequest', $parameters);
    }

    /* Payment Actions  */

    /**
     * @param array $parameters
     * @return mixed|AbstractRequest|RequestInterface
     * @throws Exception
     */
    public function purchase(array $parameters = array())
    {
        $force3ds = isset($parameters['force3ds']) ? $parameters['force3ds'] : 'auto';
        switch ($force3ds) {
            case "auto":
                return $this->purchaseAuto($parameters);
            case "0":
                return $this->createRequest('\Omnipay\Iyzico\Messages\PurchaseRequest', $parameters);
            case "1":
                return $this->purchase3d($parameters);
            default:
                throw new Exception("The parameter -> 'force3ds' should be '0','1' or 'auto'");
        }
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function purchase3d(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Messages\Purchase3dRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Messages\CompletePurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function purchaseInfo(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Messages\PurchaseInfoRequest', $parameters);
    }

    /**
     * @inheritDoc
     */
    public function refund(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Iyzico\Messages\RefundRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function cancelPurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Messages\CancelPurchaseRequest', $parameters);
    }

    /* Card Actions  */
    /**
     * @inheritDoc
     */
    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Messages\CreateCardRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function addCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Messages\AddCardRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function getCardList(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Messages\CardListRequest', $parameters);
    }

    /**
     * @inheritDoc
     */
    public function deleteCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Messages\DeleteCardRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function installmentInfo(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\Iyzico\Messages\InstallmentInfoRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return mixed|AbstractRequest|RequestInterface
     * @throws Exception
     */
    public function purchaseAuto(array $parameters)
    {
        try {
            if (isset($parameters["paymentCard"]["cardNumber"]) && $cardNumber = $parameters["paymentCard"]["cardNumber"]) {
                $cardNumber = trim(preg_replace("/[^0-9]/", "", $cardNumber)); // drop non numeric characters and trim spaces
                $installmentInfoParameters = [
                    'locale' => Locale::TR,
                    'binNumber' => substr($cardNumber, 0, 6),
                    'price' => 999,
                ];

                $response = $this->installmentInfo($installmentInfoParameters)->send();
                $installmentData = $response->getData();
                $installmentDetails = $installmentData->getInstallmentDetails();
                $installmentDetail = $installmentDetails[0];
                $force3ds = (string)$installmentDetail->getForce3ds();
            } else {
                throw new Exception("Card number is missing in parameters");
            }
        } catch (Exception $exception) {
            throw new Exception("Couldn't fetch 3d information of card number");
        }
        $parameters["force3ds"] = $force3ds;
        return $this->purchase($parameters);
    }

}
