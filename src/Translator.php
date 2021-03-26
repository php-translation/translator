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
    private $translatorServices = [];

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param string $string
     * @param string $from
     * @param string $to
     *
     * @return string|null null is return when all translators failed
     */
    public function translate($string, $from, $to)
    {
        foreach ($this->translatorServices as $service) {
            try {
                return $service->translate($string, $from, $to);
            } catch (TranslatorException\NoTranslationFoundException $e) {
                // Do nothing, try again.
            } catch (TranslatorException $e) {
                $this->log('error', $e->getMessage());
            } catch (\Exception $e) {
                $this->log('alert', $e->getMessage());
            }
        }

        return;
    }

    /**
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
     */
    private function log($level, $message, array $context = [])
    {
        if (null !== $this->logger) {
            $this->logger->log($level, $message, $context);
        }
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
