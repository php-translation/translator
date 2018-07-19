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
use Translation\Translator\TranslatorService;

/**
 * @author Baptiste Leduc <baptiste.leduc@gmail.com>
 */
abstract class AbstractTranslatorTest extends TestCase
{
    /**
     * @var TranslatorService
     */
    protected $translator = null;

    /**
     * @var array
     */
    protected $requested = ['apple', 'cherry'];

    /**
     * @var array
     */
    protected $expected = ['pomme', 'cerise'];

    /**
     * @var string
     */
    protected $from = 'en';

    /**
     * @var string
     */
    protected $to = 'fr';

    public function testTranslate()
    {
        if (null === $this->translator) {
            $this->markTestSkipped('No translator set.');
        }

        $result = $this->translator->translate($this->requested[0], $this->from, $this->to);
        $this->assertEquals($this->expected[0], $result);

        $results = $this->translator->translateArray($this->requested, $this->from, $this->to);
        $this->assertEquals($this->expected, $results);
    }
}
