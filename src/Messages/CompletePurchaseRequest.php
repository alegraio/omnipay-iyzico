<?php

namespace Omnipay\Iyzico\Messages;

use Iyzipay\Model\ThreedsPayment;
use Iyzipay\Request\CreateThreedsPaymentRequest;

class CompletePurchaseRequest extends AbstractRequest
{

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $request = new CreateThreedsPaymentRequest();
        $request->setLocale($this->getLocale());
        $request->setPaymentId($this->getPaymentId());

        ($this->getConversationId() !== null) ? $request->setConversationId($this->getConversationId()) : null; // ConversationId is optional
        ($this->getConversationData() !== null) ? $request->setConversationData($this->getConversationData()) : null; // ConversationData is optional

        $this->setRequestParams($this->transformIyzicoRequest($request));

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        # make request
        $options = $this->getOptions();
        $response = new CompletePurchaseResponse($this, ThreedsPayment::create($data, $options));
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }

    public function getConversationId()
    {
        return $this->getParameter('conversationId');
    }

    public function getConversationData()
    {
        return $this->getParameter('conversationData');
    }

    public function setConversationId($conversationId): void
    {
        $this->setParameter('conversationId', $conversationId);
    }

    public function setConversationData($conversationData): void
    {
        $this->setParameter('conversationData', $conversationData);
    }

    public function getSensitiveData(): array
    {
        return [];
    }
}