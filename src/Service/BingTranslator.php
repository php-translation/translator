<?php

/*
 * This file is part of the PHP Translation package.
 *
 * (c) PHP Translation team <tobias.nyholm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Translation\Translator\Service;

use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Psr\Http\Message\ResponseInterface;
use Translation\Translator\Exception\ResponseException;
use Translation\Translator\TranslatorService;

/**
 * @author Baptiste Leduc <baptiste.leduc@gmail.com>
 */
class BingTranslator extends HttpTranslator implements TranslatorService
{
    /**
     * @var string
     */
    private $key;

    /**
     * @param string $key Google API key
     */
    public function __construct($key, HttpClient $httpClient = null, RequestFactory $requestFactory = null)
    {
        parent::__construct($httpClient, $requestFactory);
        if (empty($key)) {
            throw new \InvalidArgumentException('Bing "key" can not be empty');
        }

        $this->key = $key;
    }

    /**
     * {@inheritdoc}
     */
    public function translate($string, $from, $to)
    {
        $body = json_encode([['Text' => $string]]);
        $url = $this->getUrl($from, $to);
        $request = $this->getRequestFactory()->createRequest('POST', $url, [], $body);

        $request = $request
            ->withHeader('Ocp-Apim-Subscription-Key', $this->key)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-ClientTraceId', $this->createGuid())
            ->withHeader('Content-length', \strlen($body));

        /** @var ResponseInterface $response */
        $response = $this->getHttpClient()->sendRequest($request);

        if (200 !== $response->getStatusCode()) {
            throw ResponseException::createNonSuccessfulResponse($this->getUrl($string, $from, $to, '[key]'));
        }

        $responseBody = $response->getBody()->__toString();
        $data = json_decode($responseBody, true);

        if (!\is_array($data)) {
            throw ResponseException::createUnexpectedResponse($url, $responseBody);
        }

        foreach ($data as $details) {
            return $details['translations'][0]['text'];
        }
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return string
     */
    private function getUrl($from, $to)
    {
        return sprintf(
            'https://api.cognitive.microsofttranslator.com/translate?api-version=3.0&to=%s&from=%s&textType=html',
            $to,
            $from
        );
    }

    /**
     * @return string
     */
    private function createGuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}
