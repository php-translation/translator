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
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class NoTranslationFoundException extends \RuntimeException
{
    public static function create()
    {
        return new self('No translation found.');
    }
}
