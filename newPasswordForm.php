<?php
 require("./security.php");

?>
<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <script src="file.js"></script>

</head>

<body>
    <div id="login" class="center">
    <h1>Промяна на парола</h1>
    <form id="changePassword" action="newPasswordForm.php" method="post">
            <label for="password">Стара парола</label>
            <input type="password" id="oldPassword" name="oldPassword">
            <label for="password">Нова парола</label>
            <input type="password" id="newPassword" name="newPassword">
            <label for="password">Повторете паролата</label>
            <input type="password" id="repeatPassword" name="repeatPassword">
            <button name="loginButton" id="loginButton">Смени</button>
        
    </form>
    <div id="errors" style="color: rgb(248, 12, 12)">
    <?php
      require_once 'db.php';

if(isset($_POST['loginButton'])){
    $username = "62351";
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $repeatPassword = $_POST['repeatPassword'];

    if(empty($oldPassword) || empty($newPassword) || empty($repeatPassword)){
        echo "Попълнете всички полета. ";
        return;

    }
    if($newPassword != $repeatPassword){
        echo "Паролите не съвпадат. ";
        return ;   
    }
        $db = new Database('mysql','localhost','attendances','root',''); 
        $connection = $db->getConnection();
        $sql = 'SELECT pass FROM `users` WHERE username=?';
        $prepared = $connection->prepare($sql);
        $prepared->execute([$username]);
        $result = $prepared->fetch(PDO::FETCH_ASSOC)['pass'];
        
        if(!password_verify($oldPassword,$result)){
            echo "Грешна стара парола";
            return;    
        }
        
        $update="update users set pass=? WHERE username=?";
        $prepared = $connection->prepare($update);
        $hashed = password_hash($newPassword, PASSWORD_ARGON2ID);
        $prepared->execute([$hashed,$username]);

        echo "Успешно променена парола";
    
}
?>
    </div>

    </div>
</body>

</html>

