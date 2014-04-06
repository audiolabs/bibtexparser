<?php

namespace AudioLabs\BibtexParser\Tests;

class BibtexParserTest extends \PHPUnit_Framework_TestCase
{
    public function test_coverage() {
        $instance = new \AudioLabs\BibtexParser\BibtexParser();
        $items = $instance->parse_file(__DIR__ . '/Fixures/publications.bib');

        $this->assertTrue(is_array($items));
    }
}
