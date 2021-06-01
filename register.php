<?php
    require_once('db.php');
    $db = new Database('mysql','localhost','attendances','root',''); 
    $connection = $db->getConnection();
    $file = 'uploads/input.csv';
    $students = array_map('str_getcsv', file($file));

    for($i=0;$i<4;$i++){
        $email = $students[$i][0];
        $fn = $students[$i][1];
        
        $name = $students[$i][2];
        $year = $students[$i][3];
        $group = $students[$i][4];
        $specialty = $students[$i][5];
        $username = $fn;
        $password = password_hash($fn, PASSWORD_ARGON2ID);
    
        $sql = 'INSERT INTO `users` (`fn`, `email`, `name`, `username`, `year`, `groupp`, `spec`, `pass`) VALUES (?, ?, ?, ?, ?, ?, ?, ?);';
        $prepared = $connection->prepare($sql);
        $prepared->execute([$fn,$email,$name,$username,$year,$group,$specialty,$password]);
       
    }
    
    
    ?>