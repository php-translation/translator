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

use Translation\Translator\Service\GoogleTranslator;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class GoogleTranslatorTest extends AbstractTranslatorTest
{
    public function setUp()
    {
        $key = getenv('GOOGLE_KEY');
        if (!empty($key)) {
            $this->translator = new GoogleTranslator($key);
        }
    }
}
