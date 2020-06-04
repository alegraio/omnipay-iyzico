<?php


namespace Omnipay\Iyzico\Messages;


use DOMDocument;
use Iyzipay\JsonBuilder;

class Purchase3dResponse extends AbstractResponse
{
    private string $formId = "iyzico-3ds-form";
    private string $threeDHtmlContent = "";

    /* @var $domDocument  domDocument */
    private ?DOMDocument $domDocument = null;

    public function isRedirect()
    {
        return true;
    }

    /**
     * @return Purchase3dResponse
     */
    private function setThreeDHtmlContent()
    {
        $rawResult = $this->getResponse()->getRawResult();
        $rawResultObj = JsonBuilder::jsonDecode($rawResult);
        $this->threeDHtmlContent = base64_decode($rawResultObj->threeDSHtmlContent, true);
        return $this;
    }

    /**
     * @return Purchase3dResponse
     */
    private function setDomDocument()
    {
        $this->domDocument = new domDocument;
        $this->domDocument->loadHTML($this->threeDHtmlContent);
        $this->domDocument->preserveWhiteSpace = false;
        return $this;
    }

    public function initHtmlData()
    {
        if (empty($this->threeDHtmlContent) || $this->domDocument === null) {
            $this
                ->setThreeDHtmlContent()
                ->setDomDocument();
        }
    }

    public function getRedirectData()
    {
        $this->initHtmlData();
        return $this->parseRedirectData();
    }

    public function getRedirectUrl()
    {
        $this->initHtmlData();
        return $this->parseRedirectUrl();
    }

    private function parseRedirectData()
    {
        $redirectData = [];
        $input_tags = $this->domDocument->getElementsByTagName("input");
        for ($i = 0; $i < $input_tags->length; $i++) {
            if (is_object($input_tags->item($i))) {
                $value = '';
                $name_o = $input_tags->item($i)->attributes->getNamedItem('name');
                if (is_object($name_o)) {
                    $name = $name_o->value;

                    $value_o = $input_tags->item($i)->attributes->getNamedItem('value');
                    if (is_object($value_o)) {
                        $value = $input_tags->item($i)->attributes->getNamedItem('value')->value;
                    }

                    $redirectData[$name] = $value;
                }
            }
        }
        return $redirectData;

    }

    private function parseRedirectUrl()
    {
        return $this->domDocument->getElementById($this->formId)->getAttribute("action");
    }

    /**
     * @return string
     */
    public function getThreeDHtmlContent(): string
    {
        return $this->threeDHtmlContent;
    }


}