<?php

namespace Omnipay\Iyzico;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Http\ClientInterface;

class IyzicoHttp
{
    protected $httpClient;

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
            $request = $this->httpClient->request('POST', $url, $this->transformHeaders($headers), $body);
            return $request->getBody()->getContents();
        } catch (\Exception $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
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