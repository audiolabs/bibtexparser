<?php

namespace AudioLabs\BibtexParser\Tests;

class BibtexParserTest extends \PHPUnit_Framework_TestCase
{
    public function test_coverage() {
        $items = \AudioLabs\BibtexParser\BibtexParser::parseFile(__DIR__ . '/Fixures/publications.bib');

        $this->assertTrue(is_array($items));
    }
}
