<?php
namespace Omnipay\Iyzico\Messages;

use Iyzipay\Model\CardList;
use Iyzipay\Model\Locale;
use Iyzipay\Request\RetrieveCardListRequest;

class CardListRequest extends AbstractRequest
{

    public function setLocale($locale)
    {
        $this->setParameter("locale", $locale);
    }

    public function getLocale()
    {
        return !empty($this->getParameter("locale")) ? $this->getParameter("locale") : Locale::TR;
    }

    public function getCardUserKey()
    {
        return $this->getParameter("cardUserKey");
    }

    public function setCardUserKey($cardUserKey)
    {
        $this->setParameter("cardUserKey", $cardUserKey);
    }

    public function buildTransactionID()
    {
        $data = array(
            "locale" => $this->getLocale(),
            "cardUserKey" => $this->getCardUserKey(),
            "id" => uniqid(),
            "timestamp" => date("YmdHis")
        );
        $data = serialize($data);
        return hash_hmac("sha1", $data, $this->getSecretKey());
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