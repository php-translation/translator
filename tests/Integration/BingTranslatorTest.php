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
use Translation\Translator\Service\BingTranslator;

/**
 * @author Baptiste Leduc <baptiste.leduc@gmail.com>
 */
class BingTranslatorTest extends TestCase
{
    public function testTranslate()
    {
        $key = getenv('BING_KEY');
        if (empty($key)) {
            $this->markTestSkipped('No Bing key in environment');
        }

        $translator = new BingTranslator($key);
        $result = $translator->translate('apple', 'en', 'fr');
        $this->assertEquals('pomme', $result);
    }
}
