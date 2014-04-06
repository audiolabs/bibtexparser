<?php

namespace AudioLabs\BibtexParser\Tests;

require 'vendor/autoload.php';

$instance = new \AudioLabs\BibtexParser\BibtexParser();
$items = $instance->parse_file(__DIR__ . '/Fixures/publications.bib');
