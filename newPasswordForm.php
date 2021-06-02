<?php
 require("./security.php");
 require_once 'db.php';

?>
<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <script src="validation.js"></script>

</head>

<body>
    <div id="login" class="center">
    <h1>Промяна на парола</h1>
    <form id="changePassword" onsubmit="return checkPasswords()">
           
            <label for="password">Стара парола</label>
            <input type="password" id="oldPassword" name="oldPassword">
            <label for="password">Нова парола</label>
            <input type="password" id="newPassword" name="newPassword">
            <label for="password">Повторете паролата</label>
            <input type="password" id="repeatPassword" name="repeatPassword">
            <button name="loginButton" id="loginButton">Смени</button>
            <div class="error" id="errors"></div>
        
    </form>
    <div id="errors" style="color: rgb(248, 12, 12)"></div>
    </div>
</body>
</html>



