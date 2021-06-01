
<?php
     session_start();
     session_regenerate_id(true);

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
    <h1>Форма за вход</h1>
    <form id="loginForm"  onsubmit="return validate()">
        
            <label for="username">Потребителско име</label>
            <input type="text" name="username" id="username">
            <label for="password">Парола</label>
            <input type="password" id="password" name="password">
            <p class="error" id="error"></p>
            <button name="loginButton" id="loginButton">Вход</button>
        
    </form>
    </div>
</body>

</html>