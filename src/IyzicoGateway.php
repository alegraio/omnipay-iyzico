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

    public function getApiSecret()
    {
        return $this->getParameter("apiSecret");
    }

    public function getBaseUrl()
    {
        return $this->getParameter("baseUrl");
    }
    public function setApiKey($apiKey)
    {
        return $this->setParameter('apiKey', $apiKey);
    }

    public function setApiSecret($apiSecret)
    {
        return $this->setParameter('apiSecret', $apiSecret);
    }

    public function setBaseUrl($baseUrl)
    {
        return $this->setParameter('baseUrl', $baseUrl);
    }

    /**
     * @inheritDoc
     */
    public function authorize(array $parameters = array()){
        return $this->createRequest('\Omnipay\Iyzico\Message\AuthorizeRequest', $parameters);
    }

    /* Payment Actions  */

    /**
     * @inheritDoc
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Message\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function purchase3d(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Message\Purchase3dRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function purchaseInfo(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Message\PurchaseInfoRequest', $parameters);
    }

    /**
     * @inheritDoc
     */
    public function refund(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\PayU\Messages\RefundRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function cancelPurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Message\CancelPurchaseRequest', $parameters);
    }

    /* Card Actions  */
    /**
     * @inheritDoc
     */
    public function createCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Message\CreateCardRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function addCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Message\AddCardRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function getCardList(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Message\CardListRequest', $parameters);
    }

    /**
     * @inheritDoc
     */
    public function deleteCard(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Iyzico\Message\DeleteCardRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function installmentInfo(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\PayU\Messages\InstallmentInfoRequest', $parameters);
    }



}