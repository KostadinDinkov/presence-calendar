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
    <link rel="stylesheet" href="css/courses.css">
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


    $sqlGetCountOfChecks = 'SELECT COUNT(DISTINCT attendancecheckID) FROM attendancecheck JOIN peopleateventcheck ON attendancecheck.checkID = peopleateventcheck.attendanceCheckID WHERE eventID = :eventID';
    $statement = $connection->prepare($sqlGetCountOfChecks);
    $statement->execute(array("eventID" => $events[$i]['id']));
    $countOfChecks = $statement->fetch(PDO::FETCH_ASSOC)['COUNT(DISTINCT attendancecheckID)'];

    $sqlGetCountOfAttendances = 'SELECT COUNT(*) FROM attendancecheck JOIN peopleateventcheck ON attendancecheck.checkID = peopleateventcheck.attendanceCheckID WHERE eventID = :eventID AND username = :username';
    $statement = $connection->prepare($sqlGetCountOfAttendances);
    $statement->execute(array("eventID" => $events[$i]['id'], "username" => $_SESSION['username']));
    $countOfAttendances = $statement->fetch(PDO::FETCH_ASSOC)['COUNT(*)'];
    
    $greenness;
    $redness;
    if($countOfChecks != 0) {
        if($countOfAttendances / $countOfChecks > 0.5){
            $greenness = 255;
            $redness = (1 - ($countOfAttendances / $countOfChecks)) * 510;
        } else {
            $redness = 255;
            $greenness = ($countOfAttendances / $countOfChecks) * 510;
        }
    } else {
        $greenness = 255;
        $redness = 0;
    }
    
    
    echo "<div><span class=\"eventName\">".$events[$i]['eventDate']." - ".$events[$i]['topic']."</span>";
    echo "<div class=\"circle\" style=\"background-color: rgba(" . $redness . ", " . $greenness . ", 0);\"></div>";

    echo "<i class=\"arrow down\" id=\"showSubevents" . $i . "\" onclick=\"showSubevents(" . $i . ")\"></i>";
    $subsql = 'select * from subevents where eventID=? order by startTime asc';
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



?>
</section>
<nav>
    <p>Влезли сте в системата като: 
        <span style="color:#f8f5f0;"><?php echo $_SESSION['name'] ?></span> <a href="login.php">(Изход)</a> </p>
    <p></p>
</nav>
</body>
</html>
