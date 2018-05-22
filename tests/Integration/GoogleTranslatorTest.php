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
use Translation\Translator\Service\GoogleTranslator;
use Translation\Translator\Service\YandexTranslator;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class GoogleTranslatorTest extends TestCase
{
    public function testTranslate()
    {
        $key = getenv('GOOGLE_KEY');
        if (empty($key)) {
            $this->markTestSkipped('No Google key in environment');
        }

        $translator = new GoogleTranslator($key);
        $result = $translator->translate('Grattis, du är klar!', 'sv', 'en');
        $this->assertEquals('Congratulations, you\'re done!', $result);
    }
}
