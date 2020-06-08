<?php

namespace Omnipay\Iyzico\Messages;

use Iyzipay\Model\Refund;
use Iyzipay\Request\CreateRefundRequest;
use Omnipay\Common\Exception\InvalidResponseException;

class RefundRequest extends AbstractRequest
{

    /**
     * Prepare payment refund data.
     *
     * @return CreateRefundRequest
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function getData(): CreateRefundRequest
    {
        $request = new CreateRefundRequest();
        $request->setLocale($this->getLocale());
        $request->setPaymentTransactionId($this->getPaymentTransactionId());
        $request->setIp($this->getClientIp());
        $request->setPrice($this->getAmount());

        return $request;
    }

    /**
     * Send request for payment refund process.
     *
     * @param mixed $data
     * @return RefundResponse
     * @throws InvalidResponseException
     */
    public function sendData($data): RefundResponse
    {
        try {
            $options = $this->getOptions();

            return new RefundResponse($this, Refund::create($data, $options));
        } catch (\Exception $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    /**
     * Set payment transaction id for item.
     *
     * @param string $paymentTransactionId
     */
    public function setPaymentTransactionId(string $paymentTransactionId): void
    {
        $this->setParameter("paymentTransactionId", $paymentTransactionId);
    }

    /**
     * Get payment transaction id for item.
     *
     * @return string
     */
    public function getPaymentTransactionId(): string
    {
        return $this->getParameter("paymentTransactionId");
    }
}