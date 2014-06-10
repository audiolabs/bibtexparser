<?php

namespace de\flatplane\BibtexParser\Tests;

use AudioLabs\BibtexParser\BibtexParser;

class BibtexParserTest extends \PHPUnit_Framework_TestCase
{
    public function test_coverage() {
        $items = BibtexParser::parseFile(__DIR__ . '/Fixures/publications.bib');

        $this->assertTrue(is_array($items));
    }
}
