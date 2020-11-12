<?php

namespace Omnipay\Iyzico\Messages;

use Iyzipay\Model\CardList;
use Iyzipay\Request\RetrieveCardListRequest;

class CardListRequest extends AbstractRequest
{
    use PurchaseRequestTrait;

    public function getCardUserKey()
    {
        return $this->getParameter('cardUserKey');
    }

    public function setCardUserKey($cardUserKey): void
    {
        $this->setParameter('cardUserKey', $cardUserKey);
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $request = new RetrieveCardListRequest();
        $request->setLocale($this->getLocale());
        $request->setConversationId($this->getConversationId());
        $request->setCardUserKey($this->getCardUserKey());

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        $options = $this->getOptions();
        $response = new CardListResponse($this, CardList::retrieve($data, $options));
        $data = $this->transformIyzicoRequest($data);
        $response->setServiceRequestParams($data);

        return $response;
    }
}