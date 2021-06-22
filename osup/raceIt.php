<?php

$connection = new PDO("mysql:host=localhost;dbname=race",'root','');

$sqlquery = 'SELECT * FROM race WHERE id=1';
$statement = $connection->prepare($sqlquery);
$statement->execute();
$value=$statement->fetch(PDO::FETCH_ASSOC)['value'];

echo $value;

$sqlquery = 'UPDATE race SET value=? WHERE id=1';
$statement = $connection->prepare($sqlquery);
$statement->execute([$value + 1]);

$sqlquery = 'SELECT * FROM race WHERE id=1';
$statement = $connection->prepare($sqlquery);
$statement->execute();
$value=$statement->fetch(PDO::FETCH_ASSOC)['value'];

echo '<br>' . $value;

?>