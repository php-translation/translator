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

use Translation\Translator\Service\YandexTranslator;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class YandexTranslatorTest extends AbstractTranslatorTest
{
    /**
     * @var array
     */
    protected $expected = ['яблоко', 'вишня'];

    /**
     * @var string
     */
    protected $to = 'ru';

    public function setUp()
    {
        $key = getenv('YANDEX_KEY');
        if (!empty($key)) {
            $this->translator = new YandexTranslator($key);
        }
    }
}
