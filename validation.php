<?php

    session_start();
	session_regenerate_id(true);
    
    require_once 'db.php';
    
    $db = new Database('mysql','localhost','attendances','root',''); 
    $connection = $db->getConnection();

if(!empty($_POST["username"]) && !empty($_POST["password"]) ){

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql="SELECT * FROM `users` WHERE username=?";
    $prepared = $connection->prepare($sql);
    $prepared->execute([$username]);
    $result= $prepared->fetch(PDO::FETCH_ASSOC);
   
    
    if(!$result){
        echo "Не съществува такова потребителско име.";
    }else{
      
        $hashed_password = $result['pass'];
        if(!password_verify($password,$hashed_password)){
            echo "Грешна парола.";
        }else{
            $_SESSION['username']=$username;
            $_SESSION['faculty']=$result['faculty'];
            $_SESSION['fn']=$result['fn'];
            $_SESSION['spec']=$result['spec'];
            $_SESSION['year']=$result['year'];
            $_SESSION['group']=$result['yeargroup'];
            $_SESSION['email']= $result['email'];
            $_SESSION['name']= $result['name'];
            $_SESSION['role']=$result['role'];
        }
    }
  
}else{
    echo "Попълнете всички полета.";
}
exit;
?>