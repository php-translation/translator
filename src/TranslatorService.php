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

/**
 * This represent a third party translation service. Like Google, Bing etc.
 */
interface TranslatorService
{
    /**
     * @param string $string text to translate
     * @param string $from   from what locale
     * @param string $to     to what locale
     *
     * @return string Return the translated string
     *
     * @throws \Translation\Translator\Exception if we could not translate string
     */
    public function translate($string, $from, $to);
}
