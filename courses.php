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
    <link rel="stylesheet" href="css/courses.css">
    <script src="js/validation.js"></script>
 </head>
<body>
<section id="personalInfo" >
    <figure><img src="images/person.png" alt="home"  id="picture"></figure>
    <p style="font-size:15pt">Добре дошли,</span> </p>
    <p id ="names" style="margin-bottom:20px;" ><?php echo $_SESSION['name'] ?></p>
</section>
<div class="spacing"></div>

<section class='forms'>

<?php
        echo "<form action=\"uploadSchedule.php?id=".$_GET['id']."\" method=\"post\" enctype=\"multipart/form-data\" id=\"uploadSchedule\">
        <legend>Качване на график на събитие</legend>
        <input class='form-input' type=\"date\" name=\"eventDate\"></input>
        <input class='form-input' type=\"text\" name=\"topic\"></input>
        <label for=\"fileToUpload\" class='form-upload'>Избор на файл</label>
        <input type=\"file\" name=\"uploadFile\" id=\"fileToUpload\"></input>
        <button class='form-button' id=\"parseButton\">Качи csv файл с график за събитие</button>
      </form>";

      $statement = $connection->prepare("SELECT * FROM events WHERE courseID = ? AND eventDate < CURDATE()");
      $statement->execute([$_GET['id']]);

      $thisCourseEvents = $statement->fetchAll(PDO::FETCH_ASSOC);
      
        echo "<form action=\"uploadAttendances.php?id=".$_GET['id']."\" method=\"post\" enctype=\"multipart/form-data\" id='uploadattendances'>
        <legend>Качване на файл с присъствие</legend>
        <label class='form-upload'><input type=\"file\" name=\"uploadFile\" id=\"fileToUpload\">Избор на файл</label>
        <select name=\"selectedEvent\" id=\"selectedEvent\">";

        for($i = 0; $i < sizeof($thisCourseEvents); $i++){
            echo "<option value=" . $thisCourseEvents[$i]["id"]  ;
            if($i == 0) {
                echo " selected ";
            }
            
            echo ">".$thisCourseEvents[$i]["topic"]."</option>";
        };


        echo "</select><button class='form-button' id=\"parseButton\">Качи bbb файл с присъствия</button>
      </form>";

      $statement = $connection->prepare("SELECT * FROM users JOIN userattends ON users.username = userattends.username  WHERE userattends.courseID = ?");
      $statement->execute([$_GET['id']]);

      $thisCourseUsers = $statement->fetchAll(PDO::FETCH_ASSOC);
      ?>
      </section>
      <div class="spacing"></div>
      <section id="selectUser">
    <?php
      echo "<form action=\"courses.php?id=".$_GET['id']."\" method=\"post\" enctype=\"multipart/form-data\" id=\"checkAttendances\">
      <label for=\"selectedUser\" id=\"h\">Проверка на присъствие за потребител</label>
      <fieldset>
      <select name=\"selectedUser\" id=\"selectedUser\">";

        if(! isset($_POST['selectedUser'])) {
            echo "<option value=\" \" selected>--------</option>" ;
        }

        for($i = 0; $i < sizeof($thisCourseUsers); $i++){
            

            echo "<option value=" . $thisCourseUsers[$i]["username"]  ;
            
            if(isset($_POST['selectedUser']) && $_POST['selectedUser'] == $thisCourseUsers[$i]["username"] )
            {
                echo " selected ";
            }
            
            echo ">".$thisCourseUsers[$i]["name"]."</option>";
        };

      echo "</select>
      <button id=\"submit\">Виж присъствие</button></fieldset>
    </form></section><section id=\"main\">";

   

    if(isset($_POST['selectedUser'])){
    
    $sql = 'select * from events where courseID=? order by eventDate desc ';
    $statement = $connection->prepare($sql);
    $statement->execute([$_GET['id']]);
    $events=$statement->fetchAll(PDO::FETCH_ASSOC);
    
    for($i=0;$i<sizeof($events);$i++){


        $sqlGetCountOfChecks = 'SELECT COUNT(DISTINCT attendancecheckID) FROM attendancecheck JOIN peopleateventcheck ON attendancecheck.checkID = peopleateventcheck.attendanceCheckID WHERE eventID = :eventID';
        $statement = $connection->prepare($sqlGetCountOfChecks);
        $statement->execute(array("eventID" => $events[$i]['id']));
        $countOfChecks = $statement->fetch(PDO::FETCH_ASSOC)['COUNT(DISTINCT attendancecheckID)'];

        $sqlGetCountOfAttendances = 'SELECT COUNT(*) FROM attendancecheck JOIN peopleateventcheck ON attendancecheck.checkID = peopleateventcheck.attendanceCheckID WHERE eventID = :eventID AND username = :username';
        $statement = $connection->prepare($sqlGetCountOfAttendances);
        $statement->execute(array("eventID" => $events[$i]['id'], "username" => $_POST['selectedUser']));
        $countOfAttendances = $statement->fetch(PDO::FETCH_ASSOC)['COUNT(*)'];
        
        $greenness;
        $redness;
        if($countOfChecks != 0) {
            if($countOfAttendances / $countOfChecks > 0.5){
                $greenness = 255;
                $redness = (($countOfAttendances / $countOfChecks) * 2 - 1) * 255;
            } else {
                $redness = 255;
                $greenness = ($countOfAttendances / $countOfChecks) * 510;
            }
        } else {
            $greenness = 255;
            $redness = 0;
        }
        
        
        echo "<div><span class=\"eventName\">".$events[$i]['eventDate']." - ".$events[$i]['topic']."</span>";
        echo "<div class=\"circle\" style=\"background-color: rgba(" . $greenness . ", " . $redness . ", 0);\"></div>";
        echo "<svg viewBox='0 0 32 32'>
        <circle r='16' cx='16' cy='16' style='stroke-dasharray: " . 100*$greenness . " 100;' />
      </svg>";
        // echo "<progress value=\"" . $greenness . "\"style=\"color: rgba(" . 255*(1-$greenness) . ", " . 255*$greenness . ", 0, 1);\"></progress>";
        // echo "<meter value=\"" . $countOfAttendances .  "\" max=\"" . $countOfChecks . "\" low=\"" . $countOfChecks/2 . "\"></meter>";   

        echo "<button id=\"showSubevents" . $i . "\" onclick=\"showSubevents(" . $i . ")\">Покажи</button>";
        $subsql = 'select * from subevents where eventID=? order by startTime desc';
        $statement = $connection->prepare($subsql);
        $statement->execute([$events[$i]['id']]);
        $subevents=$statement->fetchAll(PDO::FETCH_ASSOC);

        echo "<ul id=\"subevents" . $i . "\" style=\"display:none\" > ";
        for($j=0;$j<sizeof($subevents);$j++){
            
            $start = explode(' ',$subevents[$j]['startTime'])[1];
            $end = explode(' ',$subevents[$j]['endTime'])[1];
            echo "<li>( ".$start." - ".$end.")     -   ".$subevents[$j]['topic']."</li>";
        }
        echo "</ul></div>";
    }
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
