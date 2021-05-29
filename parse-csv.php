<?php
$file = 'uploads/sample.csv';
$csv = array_map('str_getcsv', file($file));

echo($csv[0][2]);
?>