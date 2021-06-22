<?php

// $connection = new PDO("mysql:host=localhost;dbname=race",'root','');

// $sqlquery = 'SELECT * FROM race WHERE id=1';
// $statement = $connection->prepare($sqlquery);
// $statement->execute();
// $value=$statement->fetch(PDO::FETCH_ASSOC)['value'];

// echo $value;

// sleep(10);

// $sqlquery = 'UPDATE race SET value=? WHERE id=1';
// $statement = $connection->prepare($sqlquery);
// $statement->execute([$value + 1]);

// $sqlquery = 'SELECT * FROM race WHERE id=1';
// $statement = $connection->prepare($sqlquery);
// $statement->execute();
// $value=$statement->fetch(PDO::FETCH_ASSOC)['value'];

// echo '<br>' . $value;

$pid = pcntl_fork();

if($pid) {
    echo "hello from parent";
} else {
    echo 'hello from child';
}

?>