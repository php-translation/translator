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

use Translation\Translator\Service\BingTranslator;

/**
 * @author Baptiste Leduc <baptiste.leduc@gmail.com>
 */
class BingTranslatorTest extends AbstractTranslatorTest
{
    public function setUp()
    {
        $key = getenv('BING_KEY');
        if (!empty($key)) {
            $this->translator = new BingTranslator($key);
        }
    }
}
