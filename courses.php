<?php
    require("./security.php");
    require("./db.php");
    $db = new Database('mysql','localhost','attendances','root',''); 
    $connection = $db->getConnection();
?>

<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/profile.css">
    <script src="file.js"></script>
 </head>
<body>
<section id="personalInfo" >
    <figure><img src="images/person.png" alt="home"  id="picture"></figure>
    <p style="font-size:15pt">Добре дошли,</span> </p>
    <p id ="names" ><?php echo $_SESSION['name'] ?></p>
</section>

<?php
        echo "<form action=\"uploadSchedule.php?id=".$_GET['id']."\" method=\"post\" enctype=\"multipart/form-data\">
        <input type=\"date\" name=\"eventDate\"></input>
        <input type=\"text\" name=\"topic\"></input>
        <input type=\"file\" name=\"uploadFile\" id=\"fileToUpload\">
        <button id=\"parseButton\">Качи csv файл с график за събитие</button>
      </form>";
      
        echo "<form action=\"uploadAttendances.php?id=".$_GET['id']."\" method=\"post\" enctype=\"multipart/form-data\">
        <input type=\"file\" name=\"uploadFile\" id=\"fileToUpload\">
        <button id=\"parseButton\">Качи bbb файл с присъствия</button>
      </form>";

      $statement = $connection->prepare("SELECT * FROM users JOIN userattends ON users.username = userattends.username  WHERE userattends.courseID = ?");
      $statement->execute([$_GET['id']]);

      $thisCourseUsers = $statement->fetchAll(PDO::FETCH_ASSOC);
        
      echo "<form action=\"courses.php?id=".$_GET['id']."\" method=\"post\" enctype=\"multipart/form-data\">
      <select name=\"selectedUser\" id=\"selectedUser\">";


        for($i = 0; $i < sizeof($thisCourseUsers); $i++){
            echo "<option value=" . $thisCourseUsers[$i]["username"]  ;
            if(isset($_POST['selectedUser']) && $_POST['selectedUser'] == $thisCourseUsers[$i]["username"] )
            {
                echo " selected ";
            }
            
            echo ">".$thisCourseUsers[$i]["name"]."</option>";
        };

      echo "</select>
      <button id=\"submnit\">Виж присъствие</button>
    </form>";

    if(isset($_POST['selectedUser'])){
    
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
    }

?>

<nav>
    <p>Влезли сте в системата като: 
        <span style="color:#f8f5f0;"><?php echo $_SESSION['name'] ?></span> <a href="login.php">(Изход)</a> </p>
    <p></p>
</nav>
</body>
</html>
