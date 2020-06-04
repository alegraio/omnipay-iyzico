<?php
namespace Omnipay\Iyzico\Messages;

use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\Locale;
use Iyzipay\Model\PaymentCard;
use Iyzipay\Model\ThreedsInitialize;
use Iyzipay\Request\CreatePaymentRequest;
use Omnipay\Iyzico\IyzicoItem;
use Omnipay\Iyzico\IyzicoItemBag;

class Purchase3dRequest extends AbstractRequest
{

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $request = new CreatePaymentRequest();
        $request->setLocale($this->getLocale());
        $request->setConversationId($this->getConversationId());
        $request->setPrice($this->getPrice());
        $request->setPaidPrice($this->getPaidPrice());
        $request->setCurrency($this->getCurrency());
        $request->setInstallment($this->getInstallment());
        ($this->getBasketId() !== null) ? $request->setBasketId($this->getBasketId()) : null; // BasketId is optional
        ($this->getPaymentChannel() !== null) ? $request->setPaymentChannel($this->getPaymentChannel()) : null; // PaymentChannel is optional
        ($this->getPaymentGroup() !== null) ? $request->setPaymentGroup($this->getPaymentGroup()) : null; // PaymentGroup is optional
        $request->setCallbackUrl($this->getReturnUrl());

        $paymentCard = new PaymentCard();
        $paymentCard->setCardHolderName($this->getCardHolderName());
        $paymentCard->setCardNumber($this->getCard()->getNumber());
        $paymentCard->setExpireMonth($this->getCard()->getExpiryMonth());
        $paymentCard->setExpireYear($this->getCard()->getExpiryYear());
        $paymentCard->setCvc($this->getCard()->getCvv());
        ($this->getRegisterCard() !== null) ? $paymentCard->setRegisterCard($this->getRegisterCard()) : null; // RegisterCard is optional
        $request->setPaymentCard($paymentCard);

        $buyer = new Buyer();
        $buyer->setId($this->getBuyerId());
        $buyer->setName($this->getCard()->getFirstName());
        $buyer->setSurname($this->getCard()->getLastName());
        ($this->getCard()->getPhone() !== null) ? $buyer->setGsmNumber($this->getCard()->getPhone()) : null; // GsmNumber is optional
        $buyer->setGsmNumber($this->getCard()->getPhone());
        $buyer->setEmail($this->getCard()->getEmail());
        $buyer->setIdentityNumber($this->getIdentityNumber());
        ($this->getLastLoginDate() !== null) ? $buyer->setLastLoginDate($this->getLastLoginDate()) : null; // LastLoginDate is optional
        ($this->getRegistrationDate() !== null) ? $buyer->setRegistrationDate($this->getRegistrationDate()) : null; // RegistrationDate is optional
        $buyer->setRegistrationAddress($this->getRegistrationAddress()); // If 'registrationAddress' exists, else CreditCard -> Address1
        $buyer->setIp($this->getClientIp());
        $buyer->setCity($this->getCard()->getCity());
        $buyer->setCountry($this->getCard()->getCountry());
        ($this->getCard()->getPostcode() !== null) ? $buyer->setZipCode($this->getCard()->getPostcode()) : null; // PostCode is optional
        $buyer->setZipCode($this->getCard()->getBillingPostcode());
        $request->setBuyer($buyer);

        $shippingAddress = new Address();
        $shippingAddress->setContactName($this->getShippingContactName());
        $shippingAddress->setCity($this->getCard()->getShippingCity());
        $shippingAddress->setCountry($this->getCard()->getShippingCountry());
        $shippingAddress->setAddress($this->getCard()->getShippingAddress1());
        ($this->getCard()->getShippingPostcode() !== null) ? $shippingAddress->setZipCode($this->getCard()->getShippingPostcode()) : null; // ShippingPostCode is optional
        $request->setShippingAddress($shippingAddress);

        $billingAddress = new Address();
        $billingAddress->setContactName($this->getBillingContactName());
        $billingAddress->setCity($this->getCard()->getBillingCity());
        $billingAddress->setCountry($this->getCard()->getBillingCountry());
        $billingAddress->setAddress($this->getCard()->getBillingAddress1());
        ($this->getCard()->getBillingPostcode() !== null) ? $billingAddress->setZipCode($this->getCard()->getBillingPostcode()) : null; // BillingPostcode is optional
        $request->setBillingAddress($billingAddress);

        $basketItems = $this->getBasketItems();

        $request->setBasketItems($basketItems);

        return $request;
    }

    public function getBasketItems(){
        $basketItems = [];
        /* @var IyzicoItemBag $itemBag */
        $itemBag = $this->getParameter("items");
        /* @var IyzicoItem $item */
        foreach ($itemBag->getItems() as $item) {
            $basketItem = new BasketItem();
            $basketItem->setId($item->getId());
            $basketItem->setName($item->getName());
            $basketItem->setCategory1($item->getCategory1());
            ($item->getCategory2() !== null) ? $basketItem->setCategory2($item->getCategory2()) : null; // Category2 is optional
            $basketItem->setItemType($item->getItemType());
            $basketItem->setPrice($item->getPrice());
            $basketItems[] = $basketItem;
        }
        return $basketItems;
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        # make request
        $options = $this->getOptions();
        return new Purchase3dResponse($this, ThreedsInitialize::create($data, $options));
    }

    public function setPrice($locale)
    {
        $this->setParameter("price", $locale);
    }

    public function setPaidPrice($locale)
    {
        $this->setParameter("paidPrice", $locale);
    }

    public function setInstallment($locale)
    {
        $this->setParameter("installment", $locale);
    }

    public function setBasketId($locale)
    {
        $this->setParameter("basketId", $locale);
    }

    public function setPaymentChannel($locale)
    {
        $this->setParameter("paymentChannel", $locale);
    }
    public function setPaymentGroup($locale)
    {
        $this->setParameter("paymentGroup", $locale);
    }

    public function setRegisterCard($locale)
    {
        $this->setParameter("registerCard", $locale);
    }
    public function setBuyerId($locale)
    {
        $this->setParameter("buyerId", $locale);
    }

    public function setIdentityNumber($locale)
    {
        $this->setParameter("identityNumber", $locale);
    }

    public function buildTransactionID()
    {
        $data = array(
            "locale" => $this->getLocale(),
            "id" => uniqid(),
            "timestamp" => date("YmdHis")
        );
        $data = serialize($data);
        return hash_hmac("sha1", $data, $this->getSecretKey());
    }


    private function getConversationId()
    {
        return $this->buildTransactionID();
    }

    public function getCardHolderName(){
        return $this->getCard()->getName();
    }

    private function getPrice()
    {
        return $this->getParameter("price");
    }

    private function getPaidPrice()
    {
        return $this->getParameter("paidPrice");
    }

    private function getInstallment()
    {
        return $this->getParameter("installment");
    }

    private function getBasketId()
    {
        return $this->getParameter("basketId");
    }

    private function getPaymentChannel()
    {
        return $this->getParameter("paymentChannel");
    }

    private function getPaymentGroup()
    {
        return $this->getParameter("paymentGroup");
    }

    private function getRegisterCard()
    {
        return $this->getParameter("registerCard");
    }

    private function getBuyerId()
    {
        return $this->getParameter("buyerId");
    }

    private function getIdentityNumber()
    {
        return $this->getParameter("identityNumber");
    }

    private function getLastLoginDate()
    {
        return $this->getParameter("lastLoginDate");
    }

    private function getRegistrationDate()
    {
        return $this->getParameter("registrationDate");
    }

    private function getRegistrationAddress()
    {
        return (!empty($this->getParameter("registrationAddress"))) ? $this->getParameter("registrationAddress") : $this->getCard()->getAddress1();
    }

    private function getShippingContactName()
    {
        return $this->getCard()->getShippingName();
    }

    private function getBillingContactName()
    {
        return $this->getCard()->getBillingName();
    }
}