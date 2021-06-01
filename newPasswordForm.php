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
    <form id="changePassword" action="changePassword.php" method="post">
            <label for="password">Стара парола</label>
            <input type="password" id="oldPassword" name="oldPassword">
            <label for="password">Нова парола</label>
            <input type="password" id="newPassword" name="newPassword">
            <label for="password">Повторете паролата</label>
            <input type="password" id="repeatPassword" name="repeatPassword">
            <button name="loginButton" id="loginButton">Смени</button>
        
    </form>
    </div>
</body>

</html>