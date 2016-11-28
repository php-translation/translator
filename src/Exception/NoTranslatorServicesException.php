<?php

namespace Translation\Translator\Exception;

class NoTranslatorServicesException extends \RuntimeException
{
    public static function create()
    {
        return new self('No translation services have been added.');
    }
}
