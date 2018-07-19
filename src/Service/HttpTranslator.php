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
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;
use Translation\Translator\TranslatorService;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
abstract class HttpTranslator implements TranslatorService
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var RequestFactory
     */
    private $requestFactory;

    /**
     * @param HttpClient     $httpClient
     * @param RequestFactory $requestFactory
     */
    public function __construct(HttpClient $httpClient = null, RequestFactory $requestFactory = null)
    {
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
    }

    /**
     * @return HttpClient
     */
    protected function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @return RequestFactory
     */
    protected function getRequestFactory()
    {
        return $this->requestFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function translateArray($strings, $from, $to)
    {
        $array = [];

        foreach ($strings as $string) {
            $array[] = $this->translate($string, $from, $to);
        }

        return $array;
    }

    /**
     * @param string $original
     * @param string $translationHtmlEncoded
     *
     * @return string
     */
    protected function format($original, $translationHtmlEncoded)
    {
        $translation = htmlspecialchars_decode($translationHtmlEncoded);

        // if capitalized, make sure we also capitalize.
        $firstChar = \mb_substr($original, 0, 1);
        $originalIsUpper = \mb_strtoupper($firstChar) === $firstChar;

        if ($originalIsUpper) {
            $first = \mb_strtoupper(\mb_substr($translation, 0, 1));
            $translation = $first.\mb_substr($translation, 1);
        }

        // also check on translated if capitalize and original isn't
        $transFirstChar = \mb_substr($translationHtmlEncoded, 0, 1);
        $translationIsUpper = \mb_strtoupper($transFirstChar) === $transFirstChar;

        if (!$originalIsUpper && $translationIsUpper) {
            $first = \mb_strtolower(\mb_substr($translation, 0, 1));
            $translation = $first.\mb_substr($translation, 1);
        }

        return $translation;
    }
}
