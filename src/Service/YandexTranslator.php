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
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class YandexTranslator extends HttpTranslator implements TranslatorService
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
            throw new \InvalidArgumentException('Yandex "key" can not be empty');
        }

        $this->key = $key;
    }

    /**
     * {@inheritdoc}
     */
    public function translate($string, $from, $to)
    {
        $url = $this->getUrl($string, $from, $to, $this->key);
        $request = $this->getRequestFactory()->createRequest('GET', $url);

        /** @var ResponseInterface $response */
        $response = $this->getHttpClient()->sendRequest($request);

        if (200 !== $response->getStatusCode()) {
            throw ResponseException::createNonSuccessfulResponse($this->getUrl($string, $from, $to, '[key]'));
        }

        $responseBody = $response->getBody()->__toString();
        $data = json_decode($responseBody, true);

        if (!\is_array($data)) {
            throw ResponseException::createUnexpectedResponse($this->getUrl($string, $from, $to, '[key]'), $responseBody);
        }

        foreach ($data['text'] as $translaton) {
            return $this->format($string, $translaton);
        }
    }

    /**
     * @param string $string
     * @param string $from
     * @param string $to
     * @param string $key
     *
     * @return string
     */
    private function getUrl($string, $from, $to, $key)
    {
        return sprintf(
            'https://translate.yandex.net/api/v1.5/tr.json/translate?key=%s&lang=%s-%s&text=%s&format=plain',
            $key,
            $from,
            $to,
            urlencode($string)
        );
    }

    /**
     * @param string $original
     * @param string $translationHtmlEncoded
     *
     * @return string
     */
    private function format($original, $translationHtmlEncoded)
    {
        $translation = htmlspecialchars_decode($translationHtmlEncoded);

        // if capitalized, make sure we also capitalize.
        $firstChar = mb_substr($original, 0, 1);
        if (mb_strtoupper($firstChar) === $firstChar) {
            $first = mb_strtoupper(mb_substr($translation, 0, 1));
            $translation = $first.mb_substr($translation, 1);
        }

        return $translation;
    }
}
