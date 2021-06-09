<?php
    require("./security.php");
    require("./db.php");
    $db = new Database('mysql','localhost','attendances','root',''); 
    $connection = $db->getConnection();

    
    $sql="SELECT name FROM courses  where id = ?";
    $prepared = $connection->prepare($sql);
    $prepared->execute([$_GET['id']]);
    $result = $prepared->fetch(PDO::FETCH_ASSOC)['name'];
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
    <p id ="names"><?php echo $_SESSION['name'] ?></p>
</section>
<section>
<?php

    $sql = 'select * from events where courseID=? order by eventDate desc ';
    $statement = $connection->prepare($sql);
    $statement->execute([$_GET['id']]);
    $events=$statement->fetchAll(PDO::FETCH_ASSOC);
    
    for($i=0;$i<sizeof($events);$i++){

        echo "<p>".$events[$i]['eventDate']." - ".$events[$i]['topic']."Lekciq <button id=\"showSubevents\" onclick=\"showSubevents()\">Покажи</button></p>";
        $subsql = 'select * from subevents where eventID=? order by startTime desc';
        $statement = $connection->prepare($subsql);
        $statement->execute([$events[$i]['id']]);
        $subevents=$statement->fetchAll(PDO::FETCH_ASSOC);

        echo "<ul id=\"subevents\"> ";
        for($j=0;$j<sizeof($subevents);$j++){
            
            $start = explode(' ',$subevents[$j]['startTime'])[1];
            $end = explode(' ',$subevents[$j]['endTime'])[1];
            echo "<li>( ".$start." - ".$end.")     -   ".$subevents[$j]['topic']."</li>";
        }
        echo "</ul>";
    }



?>
</section>
<nav>
    <p>Влезли сте в системата като: 
        <span style="color:#f8f5f0;"><?php echo $_SESSION['name'] ?></span> <a href="login.php">(Изход)</a> </p>
    <p></p>
</nav>
</body>
</html>
