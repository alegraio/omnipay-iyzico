<?php

namespace Omnipay\Iyzico;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Http\ClientInterface;

class IyzicoHttp
{
    protected $httpClient;
    private $url;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $url
     * @param array $headers
     * @param $body
     * @return string
     * @throws InvalidResponseException
     */
    public function post(string $url, array $headers, $body): string
    {
        try {
            $this->setUrl($url);
            $request = $this->httpClient->request('POST', $url, $this->transformHeaders($headers), $body);
            return $request->getBody()->getContents();
        } catch (\Exception $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    protected function transformHeaders(array $headers): array
    {
        $arr = [];

        foreach ($headers as $header) {
            [$k, $v] = explode(':', $header, 2);
            $arr[$k] = trim($v);
        }

        return $arr;
    }
}