
<?php
    require("./security.php");
    require_once 'db.php';

    function displayCourses(){
        
        $db = new Database('mysql','localhost','attendances','root',''); 
        $connection = $db->getConnection();
       
        if(isset($_SESSION['role'])){
            
            if(trim($_SESSION['role'])==trim('student')){
                echo "<h2>Задължителни курсове</h2><ul>";
                displayCourses1($connection);
                echo "</ul><h2>Избираеми дисциплини</h2><ul>";
                displayCourses0($connection);
            }else{
                 echo "<ul>";
                 displayTutoredCourses($connection);   
                 echo "</ul>";
            }
        }
    }

    function displayTutoredCourses($connection){
        
        $sql="select name,id from courses join userattends on courses.id = userattends.courseID where username=?";
        $prepared = $connection->prepare($sql);
        $prepared->execute([$_SESSION['username']]);
        $result = $prepared->fetch(PDO::FETCH_ASSOC);
        while($result){
            $id = $result["id"];
            echo "<li>";
            echo "<a href=courses.php?id="."$id".">";
            echo $result["name"];
            echo "</a></li>";
            $result = $prepared->fetch(PDO::FETCH_ASSOC);
    }
}

    function displayCourses1($connection){
        $sql="select name,id from courses join userattends on courses.id = userattends.courseID where username=? and userattends.mandatory=?";
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
}

    function displayCourses0($connection){
        $sql="select name,id from courses join userattends on courses.id = userattends.courseID where username=? and userattends.mandatory=?";
        $prepared = $connection->prepare($sql);
        $prepared->execute([$_SESSION['username'],0]);
        $result = $prepared->fetch(PDO::FETCH_ASSOC);
        while($result){
            $id = $result["id"];
            echo "<li>";
            echo "<a href=courses.php?id="."$id".">";
            echo $result["name"];
            echo "</a></li>";
            $result = $prepared->fetch(PDO::FETCH_ASSOC);
        }

    }
?>

<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/profile.css">
    <script src="js/validation.js"></script>
 </head>
<body>
<section id="personalInfo" >
    <figure><img src="images/person.png" alt="home"  id="picture"></figure>
    <p style="font-size:15pt">Добре дошли,</span> </p>
    <p id ="names" ><?php echo $_SESSION['name'] ?></p>
</section>
<div id="container" style="margin-top:10px">
<section id="profileInfo">
    <header>Информация за профила</header>
    <p>Име: <?php echo  $_SESSION['name']; ?></p>
    <p>Фaкултет: <?php echo  $_SESSION['faculty']; ?></p>
<?php   
    if($_SESSION['role']=='student'){
    
        echo "<p> ФН:". $_SESSION['fn'] ." </p>
        <p>Специалност:". $_SESSION['spec']." </p>
        <p>Курс: ".$_SESSION['year']."</p>
        <p>Група:". $_SESSION['group']." </p>";
    }
?> 
<p>Имейл: <?php echo  $_SESSION['email']; ?> </p>
<p >Парола : *****</p><a href="newPasswordForm.php" style="float:right; " >Редактиране на парола</a>
</section>
<div id="line"></div>
<section id="courses">
    <header>Kурсове</header>
    <?php displayCourses(); ?>
</section>
<div id="uni"></div>
</div>
<nav>
    <p>Влезли сте в системата като: 
        <span style="color:#f8f5f0;"><?php echo $_SESSION['name'] ?></span> 
        <a href="logout.php" >(Изход)</a> </p>
    
</nav>
</body>
</html>