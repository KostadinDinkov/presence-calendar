
<?php
    require("./security.php");
?>
<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="profile.css">
    <script src="file.js"></script>
 </head>
<body>
<section id="profile">
<section id="personalInfo" >
    <figure>
    <img src="images/person.png" alt="home"  id="picture">
    </figure>
    <p id ="names" style="margin-bottom:10px"> Виктория Лазарова</p>
</section>
<div id="container">
<section id="profileInfo">
    <header>Информация за профила</header>
    <p>Имейл: <?php echo  $_SESSION['email']; ?> </p>
    <p>ФН: <?php echo  $_SESSION['fn']; ?></p>
    <p>Специалност: <?php echo  $_SESSION['spec']; ?></p>
    <p>Курс: <?php echo  $_SESSION['year']; ?></p>
    <p>Група: <?php echo  $_SESSION['group']; ?></p>
    <p style="display:inline">Парола : *****</p><a href="newPasswordForm.php" style="float:right" >Редактиране на парола</a>
</section>
<section id="courses">
    <header>Записани курсове</header>
    <h2>Задължителни курсове</h2>
    <ul>
    <li></li>
    <li></li>
    <li></li>
    </ul>
    <h2>Избираеми дисциплини</h2>
    <ul>
    <li></li>
    <li></li>
    <li></li>
    </ul>
</section>
</div>
</section>

</body>
</html>