<?php


namespace Omnipay\Iyzico\Messages;


use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse implements RedirectResponseInterface
{

    public function __construct(RequestInterface $request, $data)
    {
        parent::__construct($request, $data);
        $this->setData($data);
    }


    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        if ('success' !== $this->data['status']) {
            return false;
        }

        return true;

    }

    /**
     * @param mixed $data
     * @return mixed
     */
    public function setData($data)
    {
        return $this->data = $data;
    }

}