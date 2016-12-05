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

namespace Translation\Translator\Exception;

/**
 * Whenever the translator gives a non successful response.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
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
