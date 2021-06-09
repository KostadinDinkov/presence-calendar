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

      $statement = $connection->prepare("SELECT * FROM events WHERE courseID = ? AND eventDate < CURDATE()");
      $statement->execute([$_GET['id']]);

      $thisCourseEvents = $statement->fetchAll(PDO::FETCH_ASSOC);
      
        echo "<form action=\"uploadAttendances.php?id=".$_GET['id']."\" method=\"post\" enctype=\"multipart/form-data\">
        <input type=\"file\" name=\"uploadFile\" id=\"fileToUpload\">
        <select name=\"selectedEvent\" id=\"selectedEvent\">";

        for($i = 0; $i < sizeof($thisCourseEvents); $i++){
            echo "<option value=" . $thisCourseEvents[$i]["id"]  ;
            if($i == 0) {
                echo " selected ";
            }
            
            echo ">".$thisCourseEvents[$i]["topic"]."</option>";
        };


        echo "</select><button id=\"parseButton\">Качи bbb файл с присъствия</button>
      </form>";

      $statement = $connection->prepare("SELECT * FROM users JOIN userattends ON users.username = userattends.username  WHERE userattends.courseID = ?");
      $statement->execute([$_GET['id']]);

      $thisCourseUsers = $statement->fetchAll(PDO::FETCH_ASSOC);
        
      echo "<form action=\"courses.php?id=".$_GET['id']."\" method=\"post\" enctype=\"multipart/form-data\">
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
      <button id=\"submnit\">Виж присъствие</button>
    </form>";

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
        
        echo ($countOfChecks . "/" . $countOfAttendances);
        
        echo "<p>".$events[$i]['eventDate']." - ".$events[$i]['topic']."<button id=\"showSubevents" . $i . "\" onclick=\"showSubevents(" . $i . ")\">Покажи</button></p>";
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
        echo "</ul>";
    }
    }

?>
<div id="1">111111111111</div>
<div id="2">222222222222</div>
<div id="3">333333333333</div>
<div id="4">444444444444</div>
<nav>
    <p>Влезли сте в системата като: 
        <span style="color:#f8f5f0;"><?php echo $_SESSION['name'] ?></span> <a href="login.php">(Изход)</a> </p>
    <p></p>
</nav>
</body>
</html>
