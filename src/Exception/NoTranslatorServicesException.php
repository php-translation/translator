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

class NoTranslatorServicesException extends \RuntimeException
{
    public static function create()
    {
        return new self('No translation services have been added.');
    }
}
