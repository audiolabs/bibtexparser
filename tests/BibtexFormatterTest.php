<?php

namespace de\flatplane\BibtexParser\Tests;

use de\flatplane\BibtexParser\BibtexFormatter;
use de\flatplane\BibtexParser\BibtexParser;

class BibtexFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function test_coverage() {
        $instance = new BibtexParser();
        $items = $instance->parseFile(__DIR__ . '/Fixures/publications.bib');

        foreach($items as &$item) {
            $formatted = BibtexFormatter::format($item);
        }

        $this->assertTrue(TRUE);
    }
}
