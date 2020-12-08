<?php

namespace Omnipay\Iyzico\Messages;

use DOMAttr;
use DOMDocument;
use Iyzipay\JsonBuilder;

class Purchase3dResponse extends AbstractResponse
{
    private $formId = 'iyzico-3ds-form';
    private $threeDHtmlContent = '';

    /* @var $domDocument  domDocument */
    private $domDocument = null;

    public function isRedirect(): bool
    {
        return $this->isSuccessful();
    }

    /**
     * @return Purchase3dResponse
     */
    private function setThreeDHtmlContent(): Purchase3dResponse
    {
        $rawResult = $this->getResponse()->getRawResult();
        $rawResultObj = JsonBuilder::jsonDecode($rawResult);
        $this->threeDHtmlContent = base64_decode($rawResultObj->threeDSHtmlContent, true);
        return $this;
    }

    /**
     * @return Purchase3dResponse
     */
    private function setDomDocument(): Purchase3dResponse
    {
        $this->domDocument = new domDocument;
        $this->domDocument->loadHTML($this->threeDHtmlContent);
        $this->domDocument->preserveWhiteSpace = false;
        return $this;
    }

    public function initHtmlData(): void
    {
        if (empty($this->threeDHtmlContent) || $this->domDocument === null) {
            $this
                ->setThreeDHtmlContent()
                ->setDomDocument();
        }
    }

    public function getRedirectData(): array
    {
        $this->initHtmlData();
        return $this->parseRedirectData();
    }

    public function getRedirectUrl(): ?string
    {
        $this->initHtmlData();
        return $this->parseRedirectUrl();
    }

    private function parseRedirectData(): array
    {
        $redirectData = [];
        $input_tags = $this->domDocument->getElementsByTagName('input');
        for ($i = 0; $i < $input_tags->length; $i++) {
            if (is_object($input_tags->item($i))) {
                $value = '';
                /* @var $name_o DOMAttr */
                $name_o = $input_tags->item($i)->attributes->getNamedItem('name');
                /* @var $type_o DOMAttr */
                $type_o = $input_tags->item($i)->attributes->getNamedItem('type');
                if (is_object($type_o) && $type_o !== null) {
                    if ($type_o->value === 'submit') {
                        continue;
                    }
                }
                if (is_object($name_o) && $name_o !== null) {
                    $name = $name_o->value;

                    /* @var $value_o DOMAttr */
                    $value_o = $input_tags->item($i)->attributes->getNamedItem('value');
                    if (is_object($value_o)) {
                        $value = $value_o->value;
                    }

                    $redirectData[$name] = $value;
                }
            }
        }
        return $redirectData;

    }

    private function parseRedirectUrl(): string
    {
        $redirectUrl = '';
        if (!$forms = $this->domDocument->getElementsByTagName('form')) {
            return $redirectUrl;
        }
        for ($i = 0; $i < $forms->length; $i++) {
            if (is_object($forms->item($i))) {
                /* @var $action_o DOMAttr */
                $action_o = $forms->item($i)->attributes->getNamedItem('action');
                if (is_object($action_o) && $action_o !== null) {
                    $redirectUrl = $action_o->value;
                }
            }
        }
        return $redirectUrl;
    }

    /**
     * @return string
     */
    public function getThreeDHtmlContent(): string
    {
        return $this->threeDHtmlContent;
    }

}