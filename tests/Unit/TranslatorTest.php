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

namespace Translation\translator\tests\Unit;

use Nyholm\NSA;
use Translation\Translator\Translator;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class TranslatorTest extends \PHPUnit_Framework_TestCase
{
    public function testAddTranslatorService()
    {
        $translator = new Translator();
        $this->assertEmpty(NSA::getProperty($translator, 'translatorServices'));

        $translator->addTranslatorService(new Translator());
        $this->assertCount(1, NSA::getProperty($translator, 'translatorServices'));
    }
}
