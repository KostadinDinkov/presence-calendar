<?php
    require("./security.php");
    require("./db.php");
?>

<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="profile.css">
    <script src="file.js"></script>
 </head>
<body>
    <h1> Присъствие на <?php echo $_SESSION['name'] ?> <br>
    за курс: <?php 
        $db = new Database('mysql','localhost','attendances','root',''); 
        $connection = $db->getConnection();
        $sql="SELECT name FROM courses  where id = ?";
        $prepared = $connection->prepare($sql);
        $prepared->execute([$_GET['id']]);
        $result = $prepared->fetch(PDO::FETCH_ASSOC)['name'];
        echo($result);
    ?>

<nav>
    <p>Влезли сте в системата като: 
        <span style="color:#f8f5f0;"><?php echo $_SESSION['name'] ?></span> <a href="login.php">(Изход)</a> </p>
    <p></p>
</nav>
</body>
</html>