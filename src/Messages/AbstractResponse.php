<?php

namespace Omnipay\Iyzico\Messages;

use Iyzipay\IyzipayResource;
use Iyzipay\Model\BasicPaymentResource;
use Iyzipay\Model\Cancel;
use Iyzipay\Model\PaymentResource;
use Iyzipay\Model\RefundResource;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse implements RedirectResponseInterface
{
    /** @var IyzipayResource */
    private $response;

    /** @var array */
    public $serviceRequestParams;

    public function __construct(RequestInterface $request, IyzipayResource $data)
    {
        parent::__construct($request, $data);
        $this->setResponse($data);
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return !('success' !== $this->response->getStatus());
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data = json_decode($this->response->getRawResult(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function getTransactionReference()
    {
        if (
            (
                $this->response instanceof PaymentResource ||
                $this->response instanceof Cancel ||
                $this->response instanceof BasicPaymentResource ||
                $this->response instanceof RefundResource
            ) &&
            method_exists($this->response, 'getPaymentId')
        ) {
            return $this->response->getPaymentId();
        }
        return null;
    }

    /**
     * @return IyzipayResource
     */
    public function getResponse(): IyzipayResource
    {
        return $this->response;
    }

    /**
     * @param IyzipayResource $response
     */
    public function setResponse(IyzipayResource $response): void
    {
        $this->response = $response;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        if (!empty($this->response->getErrorMessage())) {
            return $this->response->getErrorCode() . ' : ' . $this->response->getErrorMessage();
        }

        return null;
    }

    public function getRedirectMethod(): string
    {
        return 'POST';
    }

    /**
     * @return array
     */
    public function getServiceRequestParams(): array
    {
        return $this->serviceRequestParams;
    }

    /**
     * @param array $serviceRequestParams
     */
    public function setServiceRequestParams(array $serviceRequestParams): void
    {
        $this->serviceRequestParams = $serviceRequestParams;
    }
}
