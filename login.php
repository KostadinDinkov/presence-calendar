
<?php
     session_start();
     session_regenerate_id(true);

?>

<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/validation.js"></script>

</head>

<body>
    <div id="login" class="center">
    <form id="loginForm"  onsubmit="return validate()">
        <h1>Вход</h1>
        <label for="username">Потребителско име</label>
        <input type="text" name="username" id="username">
        <label for="password">Парола</label>
        <input type="password" id="password" name="password">
        <p class="error" id="error"></p>
        <button name="loginButton" id="loginButton">Влизане</button>
        
    </form>
</div>
</body>

</html>