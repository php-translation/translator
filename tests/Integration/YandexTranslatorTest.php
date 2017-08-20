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

namespace Translation\translator\tests\Integration;

use PHPUnit\Framework\TestCase;
use Translation\Translator\Service\YandexTranslator;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class YandexTranslatorTest extends TestCase
{
    public function testTranslate()
    {
        $key = getenv('YANDEX_KEY');
        if (empty($key)) {
            $this->markTestSkipped('No Yandex key in environment');
        }

        $translator = new YandexTranslator($key);
        $result = $translator->translate('apple', 'en', 'ru');
        $this->assertEquals('яблоко', $result);
    }
}
