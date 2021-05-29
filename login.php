
<?php
if(isset($_GET['err'])){
    
    echo '<script type="text/javascript">',
    'jsfunction();',
    '</script>';

    if($_GET['err']==0){
        echo "Попълнете всички полета.";
    }else if($_GET['err']==1){
        echo "Не съществува такова потребителско име.";
    }else {
        echo "Грешна парола.";
    }
}

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