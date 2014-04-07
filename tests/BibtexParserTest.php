<?php

namespace AudioLabs\BibtexParser\Tests;

class BibtexParserTest extends \PHPUnit_Framework_TestCase
{
    public function test_coverage() {
        $items = \AudioLabs\BibtexParser\BibtexParser::parse_file(__DIR__ . '/Fixures/publications.bib');

        $this->assertTrue(is_array($items));
    }
}
