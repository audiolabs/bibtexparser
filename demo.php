<?php

namespace de\flatplane;

use de\flatplane\BibtexParser\BibtexParser;

include 'vendor/autoload.php';
$filename = 'tests/Fixures/publications.bib';
var_dump(BibtexParser::parseFile($filename));
