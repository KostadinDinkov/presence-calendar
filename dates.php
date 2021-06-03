<?php

require_once('db.php');
session_start();
session_regenerate_id(true);

$connection = new Database("mysql", "localhost", "attendances", "root", "");

$statement = $connection->getConnection()->prepare("SELECT checktime
FROM attendancecheck 
JOIN peopleateventcheck ON peopleateventcheck.attendanceCheckID = attendancecheck.checkID 
JOIN courses ON courses.id = attendancecheck.courseID
WHERE peopleateventcheck.username = ?");
$statement->execute([$_SESSION['username']]);

// var_dump($_SESSION['username']);

while($time = $statement->fetch(PDO::FETCH_ASSOC)){
var_dump($time);

};



?>