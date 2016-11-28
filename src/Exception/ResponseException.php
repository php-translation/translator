<?php

namespace Translation\Translator\Exception;

class ResponseException extends \RuntimeException
{
    public static function createNonSuccessfulResponse($url)
    {
        return new self('Did not get a 200 response for URL '.$url);
    }

    public static function createUnexpectedResponse($url, $body)
    {
        return new self(sprintf("Unexpected response for URL %s. \n\n %s", $url, $body));
    }
}
