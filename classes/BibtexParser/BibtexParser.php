<?php

namespace de\flatplane\BibtexParser;

class BibtexParser
{
    public static function parseFile($filename)
    {
        return self::parseLines(file($filename));
    }

    public static function parseString($data)
    {
        return self::parseLines(preg_split('/\n/', $data));
    }

    public static function parseLines($lines)
    {
        $items = array();
        $count = -1;

        if (!$lines) {
            return;
        }

        foreach ($lines as $number => $line) {
            $line = trim($line);

            // empty line
            if (!strlen($line)) {
                continue;
            }

            // some funny comment string
            if (strpos(strtolower($line), '@string') !== false) {
                continue;
            }

            // pybliographer comments
            if (strpos(strtolower($line), '@comment') !== false) {
                continue;
            }

            // normal TeX style comment
            if ($line[0] == "%") {
                continue;
            }

            // begins with @, for example @inproceedings{...}
            if ($line[0] == "@") {
                $count++;
                $handle = "";
                $value = "";
                $data = "";
                $start = strpos($line, '@');
                $end = strpos($line, '{');
                $items[$count] = array();
                $items[$count]['raw'] = "";
                $items[$count]['type'] = trim(substr($line, 1, $end - 1));
                $items[$count]['reference'] = trim(substr($line, $end + 1), ', ');
                $items[$count]['lines'] = array('start' => $number + 1, 'end' => $number + 1);
            } elseif (substr_count($line, '=') > 0) { // contains =, for example authors = {...}
                $start = strpos($line, '=');
                $handle = strtolower(trim(substr($line, 0, $start)));
                $data = trim(substr($line, $start+1));

                if ($handle == 'pages') {
                    preg_match('%(\d+)\s*\-+\s*(\d+)%', $data, $matches);
                    if (count($matches) > 2) {
                        $value = array('start' => $matches[1], 'end' => $matches[2]);
                    } else {
                        $value = $data;
                    }
                } elseif ($handle == 'author') {
                    $value = explode(' and ', $data);
                } else {
                    $value = $data;
                }
            } else { // neither a new block nor a new field: a following line of a multiline field
                if (!is_array($value)) {
                    $value.= ' ' . $line;
                }
            }

            $items[$count]['raw'] .= $line . "\n";

            if ($value != "") {
                $items[$count][$handle] = self::cleanup($value);
            }
            if (count($items) > 0) {
                $items[$count]['lines']['end'] = $number + 1;
            }
        }
        return $items;
    }

    public static function cleanup($value)
    {
        // call cleanup() recursively if passed an array (authors or pages).
        if (is_array($value)) {
            return array_map(
                array('\de\flatplane\BibtexParser\BibtexParser', 'cleanup'),
                $value
            );
        }

        // replace a bunch of LaTeX stuff
        $search = array('\"a', '\"A', '\"o', '\"O', '\"u', '\U"', '\ss', '\`e', '\´e',
            '\url{', '{', '}', '--', '\"', '\'', '`', '\textbackslash');
        $replace = array('ä', 'Ä', 'ö', 'Ö', 'ü', 'Ü', 'ß', 'è', 'é', '', '', '',
            '&mdash;', ' ', ' ', ' ', '\\');
        $value = rtrim(str_replace($search, $replace, $value), '}, ');
        return trim($value);
    }
}
