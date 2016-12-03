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

namespace Translation\Translator;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Translation\Translator\Exception\NoTranslatorServicesException;
use Translation\Translator\Exception as TranslatorException;

/**
 * This main translator could also be called ChainTranslator. It may take multiple translator services and call them
 * one by one util one succeed. This will NOT throw an exception on failed response.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Translator implements LoggerAwareInterface, TranslatorService
{
    /**
     * @var TranslatorService[]
     */
    private $translatorServices;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param string $string
     * @param string $from
     * @param string $to
     *
     * @return null|string Null is return when all translators failed.
     *
     * @throws NoTranslatorServicesException if we failed to add translation services before calling this function.
     */
    public function translate($string, $from, $to)
    {
        if (empty($this->translatorServices)) {
            throw NoTranslatorServicesException::create();
        }

        foreach ($this->translatorServices as $service) {
            try {
                return $service->translate($string, $from, $to);
            } catch (TranslatorException $e) {
                $this->log('error', $e->getMessage());
            } catch (\Exception $e) {
                $this->log('alert', $e->getMessage());
            }
        }

        return;
    }

    /**
     * @param TranslatorService $thirdPartyService
     *
     * @return Translator
     */
    public function addTranslatorService(TranslatorService $thirdPartyService)
    {
        $this->translatorServices[] = $thirdPartyService;

        return $this;
    }

    /**
     * Log something.
     *
     * @param string $level
     * @param string $message
     * @param array  $context
     */
    private function log($level, $message, array $context = [])
    {
        if ($this->logger !== null) {
            $this->logger->log($level, $message, $context);
        }
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
