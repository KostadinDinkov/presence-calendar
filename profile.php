
<?php
    require("./security.php");
    require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="profile.css">
    <script src="validation.js"></script>
 </head>
<body>
<section id="personalInfo" >
    <figure>
    <img src="images/person.png" alt="home"  id="picture">
    </figure>
    <p style="margin-left:10px ;font-size:15pt">Добре дошли,</span> </p>
    <p id ="names" style="margin-bottom:10px"><?php echo $_SESSION['name'] ?></p>
</section>
<div id="container" style="margin-top:10px">
<section id="profileInfo">
    <header>Информация за профила</header>
    <p>Имейл: <?php echo  $_SESSION['email']; ?> </p>
    <p>ФН: <?php echo  $_SESSION['fn']; ?></p>
    <p>Специалност: <?php echo  $_SESSION['spec']; ?></p>
    <p>Курс: <?php echo  $_SESSION['year']; ?></p>
    <p>Група: <?php echo  $_SESSION['group']; ?></p>
    <p style="display:inline">Парола : *****</p><a href="newPasswordForm.php" style="float:right; " >Редактиране на парола</a>
</section>
<div id="line"></div>
<section id="courses">
    <header>Записани курсове</header>
    <h2>Задължителни курсове</h2>
    <ul>
    <?php
        
        $db = new Database('mysql','localhost','attendances','root',''); 
        $connection = $db->getConnection();
        $sql="select name,id from courses join userattends on courses.id = userattends.courseID where username=? and userattends.mandatory=?";
        $prepared = $connection->prepare($sql);
        $prepared->execute([$_SESSION['username'],0]);
        $result = $prepared->fetch(PDO::FETCH_ASSOC);
        while($result){
            $id = $result["id"];
            echo "<li>";
            echo "<a href=courses.php?id="."$id".">";
            echo $result["name"];
            echo "</li>";
            $result = $prepared->fetch(PDO::FETCH_ASSOC);
        }
    ?>
    </ul>
    <h2>Избираеми дисциплини</h2>
    <ul>
    <?php
        
        $prepared = $connection->prepare($sql);
        $prepared->execute([$_SESSION['username'],1]);
        $result = $prepared->fetch(PDO::FETCH_ASSOC);
        while($result){
            $id = $result["id"];
            echo "<li>";
            echo "<a href=courses.php?id="."$id".">";
            echo $result["name"];
            echo "</a></li>";
            $result = $prepared->fetch(PDO::FETCH_ASSOC);
        }
    ?>
    </ul>
</section>
<div id="uni"></div>
</div>
<nav>
    <p>Влезли сте в системата като: 
        <span style="color:#f8f5f0;"><?php echo $_SESSION['name'] ?></span> <a href="login.php">(Изход)</a> </p>
    <p></p>
</nav>
</body>
</html>