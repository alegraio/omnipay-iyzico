<?php
/**
 * Iyzico Class using API
 */

namespace Omnipay\Iyzico;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;


/**
 * @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())
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
     * @inheritDoc
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Messages\PurchaseRequest', $parameters);
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
}
