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

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        # make request
        $options = $this->getOptions();
        return new CompletePurchaseResponse($this, ThreedsPayment::create($data, $options));
    }

    public function getConversationId()
    {
        return $this->getParameter("conversationId");
    }

    public function getConversationData()
    {
        return $this->getParameter("conversationData");
    }

    public function setConversationId($conversationId)
    {
        $this->setParameter("conversationId", $conversationId);
    }

    public function setConversationData($conversationData)
    {
        $this->setParameter("conversationData", $conversationData);
    }
}