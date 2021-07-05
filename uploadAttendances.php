
<?php
function parseFile($file){
require_once('db.php');

$row = 1;
$meetingAndTime;
$meetingTime;
$meetingName;
$people;

$connection = new Database();

if (($handle = fopen($file, "r")) !== FALSE) {
  $i = 0;
  $lines;
  while (!feof($handle)) {
  	$lines[$i] = fgets($handle);
   	$i++;
  }

  $meetingAndTime = explode("meeting ", $lines[0], 2)[1];
  $meetingName = explode(" at ", $meetingAndTime)[0];

  $meetingInfo = preg_split("/(:| |\/)/", explode(" at ", $meetingAndTime)[1]);


  for ($i = 3; strlen($lines[$i]) > 3 ; $i++) { 
  	$people[$i - 3] = explode(" ", $lines[$i]);
  }

  $statement = $connection->getConnection()->prepare("SELECT checkID FROM attendancecheck WHERE checktime = :checktime");
  $statement->execute(array(":checktime" => $meetingInfo[2] . "-" . $meetingInfo[0] . "-" . $meetingInfo[1] . " " . $meetingInfo[3] . ":" . $meetingInfo[4] . ":" . $meetingInfo[5]));
  if($statement->fetch(PDO::FETCH_ASSOC)){
  	fclose($handle);
  	exit();
  };



  $statement = $connection->getConnection()->prepare("INSERT INTO attendancecheck(checktime, eventID, courseID) VALUES (:checktime, :eventID, :courseID)");
  $statement->execute(array(":checktime" => $meetingInfo[2] . "-" .$meetingInfo[0] . "-" .$meetingInfo[1] . " " .$meetingInfo[3] . ":" .$meetingInfo[4] . ":" . $meetingInfo[5], ":eventID" => $_POST["selectedEvent"], "courseID" => $_GET['id']));

  $statement = $connection->getConnection()->prepare("SELECT checkID FROM attendancecheck WHERE checktime = :checktime AND eventID = :eventID");
  $statement->execute(array(":checktime" => $meetingInfo[2] . "-" .$meetingInfo[0] . "-" .$meetingInfo[1] . " " .$meetingInfo[3] . ":" .$meetingInfo[4] . ":" . $meetingInfo[5], ":eventID" => $_POST['selectedEvent']));

  $checkID = $statement->fetch(PDO::FETCH_ASSOC)['checkID'];


  for ($i=0; isset($people[$i]) ; $i++) { 
	  $statement = $connection->getConnection()->prepare("SELECT username FROM users WHERE name LIKE :name");
  	$statement->execute(array(":name" => trim($people[$i][0]) . "%" . trim($people[$i][1]) . "%"));

    echo($people[$i][0] . "%" . $people[$i][1] . "%");

  	$username = $statement->fetch(PDO::FETCH_ASSOC)['username'];

    if(!isset($username)) continue;

  	$statement = $connection->getConnection()->prepare("INSERT INTO peopleateventcheck(attendanceCheckID, username) VALUES (:checkID, :username)");
  	$statement->execute(array(":checkID" => $checkID, ":username" => $username));
  }

  fclose($handle);
}
}


?>
<?php
$uploadDir = "uploads/";
$filePath = $uploadDir . basename($_FILES["uploadFile"]["name"]);
$fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));



if($fileExtension != "txt" && $fileExtension != "csv") {
  echo "Sorry, only TXT and CSV files are allowed at the moment.";
}

  if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $filePath)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["uploadFile"]["name"])). " has been uploaded.";
    parseFile($filePath);

  } else {
    echo "Sorry, there was an error uploading your file.";
  }

  header('Location: upload.php?id=' . $_GET['id'] . '');

?>
