<?php
/**
 * Iyzico Class using API
 */

namespace Omnipay\Iyzico;

use Exception;
use Iyzipay\Model\InstallmentDetail;
use Iyzipay\Model\Locale;
use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Iyzico\Messages\Purchase3dRequest;
use Omnipay\Iyzico\Messages\PurchaseRequest;
use Omnipay\Iyzico\Messages\CompletePurchaseRequest;
use Omnipay\Iyzico\Messages\PurchaseInfoRequest;
use Omnipay\Iyzico\Messages\RefundRequest;
use Omnipay\Iyzico\Messages\CancelPurchaseRequest;
use Omnipay\Iyzico\Messages\CreateCardRequest;
use Omnipay\Iyzico\Messages\AddCardRequest;
use Omnipay\Iyzico\Messages\CardListRequest;
use Omnipay\Iyzico\Messages\DeleteCardRequest;
use Omnipay\Iyzico\Messages\InstallmentInfoRequest;
use Omnipay\Iyzico\Messages\AuthorizeRequest;


/**
 * @method NotificationInterface acceptNotification(array $options = array())
 * @method RequestInterface completeAuthorize(array $options = array())
 * @method RequestInterface capture(array $options = array())
 * @method RequestInterface fetchTransaction(array $options = [])
 * @method RequestInterface void(array $options = array())
 * @method RequestInterface updateCard(array $options = array())
 */
class IyzicoGateway extends AbstractGateway
{

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Iyzico';
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    public function getBaseUrl()
    {
        return $this->getParameter('baseUrl');
    }

    public function setApiKey($apiKey): IyzicoGateway
    {
        return $this->setParameter('apiKey', $apiKey);
    }

    public function setSecretKey($apiSecret): IyzicoGateway
    {
        return $this->setParameter('secretKey', $apiSecret);
    }

    public function setBaseUrl($baseUrl): IyzicoGateway
    {
        return $this->setParameter('baseUrl', $baseUrl);
    }

    /**
     * @inheritDoc
     */
    public function authorize(array $parameters = array())
    {
        return $this->createRequest(AuthorizeRequest::class, $parameters);
    }

    /* Payment Actions  */

    /**
     * @param array $parameters
     * @return mixed|AbstractRequest|RequestInterface
     * @throws Exception
     */
    public function purchase(array $parameters = array())
    {
        $force3ds = $parameters['force3ds'] ?? 'auto';
        switch ($force3ds) {
            case 'auto':
                return $this->purchaseAuto($parameters);
            case '0':
                return $this->createRequest(PurchaseRequest::class, $parameters);
            case '1':
                return $this->purchase3d($parameters);
            default:
                throw new \RuntimeException("The parameter -> 'force3ds' should be '0','1' or 'auto'");
        }
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function purchase3d(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest(Purchase3dRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function completePurchase(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function purchaseInfo(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest(PurchaseInfoRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function refund(array $parameters = [])
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function cancelPurchase(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest(CancelPurchaseRequest::class, $parameters);
    }

    /* Card Actions  */
    /**
     * @inheritDoc
     */
    public function createCard(array $parameters = array())
    {
        return $this->createRequest(CreateCardRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function addCard(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest(AddCardRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function getCardList(array $parameters = array()): AbstractRequest
    {
        return $this->createRequest(CardListRequest::class, $parameters);
    }

    /**
     * @inheritDoc
     */
    public function deleteCard(array $parameters = array())
    {
        return $this->createRequest(DeleteCardRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest
     */
    public function installmentInfo(array $parameters = []): AbstractRequest
    {
        return $this->createRequest(InstallmentInfoRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return mixed|AbstractRequest|RequestInterface
     * @throws Exception
     */
    public function purchaseAuto(array $parameters)
    {
        try {
            if (isset($parameters['card']['number']) && $cardNumber = $parameters['card']['number']) {
                $cardNumber = trim(preg_replace('/[\D]/', '',
                    $cardNumber)); // drop non numeric characters and trim spaces
                $installmentInfoParameters = [
                    'locale' => Locale::TR,
                    'binNumber' => substr($cardNumber, 0, 6),
                    'price' => 999
                ];

                $response = $this->installmentInfo($installmentInfoParameters)->send();
                $installmentData = $response->getData();

                if (false === $installmentData) {
                    throw new \RuntimeException('Card installment details could not be retrieved');
                }
                $installmentDetails = $installmentData->getInstallmentDetails();
                $installmentDetail = $installmentDetails[0];
                /* @var $installmentDetail InstallmentDetail */
                $force3ds = (string)$installmentDetail->getForce3ds();
            } else {
                throw new \RuntimeException('Card number is missing in parameters');
            }
        } catch (Exception $exception) {
            throw new \RuntimeException("Couldn't fetch 3d information of card number");
        }
        $parameters['force3ds'] = $force3ds;
        return $this->purchase($parameters);
    }

}
