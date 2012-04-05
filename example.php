<?php

use \JTS\IncomeTax\Calculator;
use \JTS\IncomeTax\Rule;

require_once 'Source/JTS/IncomeTax/Calculator.php';
require_once 'Source/JTS/IncomeTax/Rule.php';

$calculator = new Calculator();
$calculator->rule()->max(1950000)->rate(5)->deduction(0);
$calculator->rule()->max(3300000)->rate(10)->deduction(97500);
$calculator->rule()->max(6950000)->rate(20)->deduction(427500);
$calculator->rule()->max(9000000)->rate(23)->deduction(636000);
$calculator->rule()->max(18000000)->rate(33)->deduction(1536000);
$calculator->rule()->max(PHP_INT_MAX)->rate(40)->deduction(2796000);

$incomeTax = $calculator->getTax(3000000);
var_dump(number_format($incomeTax));

$incomeTax = $calculator->getTax(5000000);
var_dump(number_format($incomeTax));

$incomeTax = $calculator->getTax(7000000);
var_dump(number_format($incomeTax));

$incomeTax = $calculator->getTax(10000000);
var_dump(number_format($incomeTax));