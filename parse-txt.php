<?php
$row = 1;
$file = "uploads/sample.txt";

if (($handle = fopen($file, "r")) !== FALSE) {
  while (!feof($handle)) {
    $line = fgets($handle);
    $person = explode(" ", $line);

    echo($person[0]);
  }
  fclose($handle);
}
?>