<?php

namespace AudioLabs\BibtexParser\Tests;

class BibtexFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function test_coverage() {
        $instance = new \AudioLabs\BibtexParser\BibtexParser();
        $items = $instance->parseFile(__DIR__ . '/Fixures/publications.bib');

        foreach($items as &$item) {
            $formatted = \AudioLabs\BibtexParser\BibtexFormatter::format($item);
        }

        $this->assertTrue(TRUE);
    }
}
