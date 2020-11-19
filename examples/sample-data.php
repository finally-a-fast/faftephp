<?php

$stdClass = new stdClass();
$stdClass->a = 'class item a';
$stdClass->b = 'class item b';

$numericArray = [
    'a', 'b', 'c', 'd'
];

$array = [
    'a' => 'aA', 'b' => 'bB', 'c' => 'cC', 'd' => 'dD'
];

$deepStructure = $array;
$deepStructure['e'] = $array;
$deepStructure['f'] = $stdClass;
$deepStructure['g'] = $numericArray;
$deepStructure['g'][] = $deepStructure;

return [
    'string' => 'Test string',
    'string-with-break' => 'Test string with' . PHP_EOL . ' break',
    'small-int' => 2,
    'int' => 42,
    'float' => 42.23,
    'bool-false' => false,
    'bool-true' => true,
    'numeric-array' => $numericArray,
    'array' => $array,
    'stdclass' => $stdClass,
    'deep-structure' => $deepStructure,
    'parsable-string' => '<fafte-strtoupper>\'parsed string\'</fafte-strtoupper>'
];
