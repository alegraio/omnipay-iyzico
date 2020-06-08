<?php

namespace Omnipay\Iyzico\Messages;

use Iyzipay\Model\CardList;
use Iyzipay\Request\RetrieveCardListRequest;
use Omnipay\Iyzico\Helper\IzyicoHelper;

class CardListRequest extends AbstractRequest
{
    public function getCardUserKey()
    {
        return $this->getParameter('cardUserKey');
    }

    public function setCardUserKey($cardUserKey): void
    {
        $this->setParameter('cardUserKey', $cardUserKey);
    }

    public function buildTransactionID()
    {
        $data = array(
            'locale' => $this->getLocale(),
            'cardUserKey' => $this->getCardUserKey(),
            'id' => IzyicoHelper::createUniqueID(),
            'timestamp' => date('YmdHis')
        );
        $data = serialize($data);
        return hash_hmac('sha1', $data, $this->getSecretKey());
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $request = new RetrieveCardListRequest();
        $request->setLocale($this->getLocale());
        $request->setConversationId($this->buildTransactionID());
        $request->setCardUserKey($this->getCardUserKey());

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        $options = $this->getOptions();
        return new CardListResponse($this, CardList::retrieve($data, $options));
    }

}