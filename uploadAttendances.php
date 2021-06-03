
<?php
function parseFile($file){
require_once('db.php');

$row = 1;
$meetingAndTime;
$meetingTime;
$meetingName;
$people;

$connection = new Database("mysql", "localhost", "attendances", "root", "");

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

  for ($i = 6; strlen($lines[$i]) > 3 ; $i++) { 
  	$people[$i - 6] = explode(" ", $lines[$i]);
  }

  $statement = $connection->getConnection()->prepare("SELECT checkID FROM attendancecheck WHERE checktime = :checktime AND eventName = :event");
  $statement->execute(array(":checktime" => $meetingInfo[2] . "-" .$meetingInfo[1] . "-" .$meetingInfo[0] . " " .$meetingInfo[3] . ":" .$meetingInfo[4] . ":" . $meetingInfo[5], ":event" => $meetingName));
  if($statement->fetch(PDO::FETCH_ASSOC)){
  	fclose($handle);
  	exit();
  };

  $statement = $connection->getConnection()->prepare("INSERT INTO attendancecheck(checktime, eventName) VALUES (:checktime, :event)");
  $statement->execute(array(":checktime" => $meetingInfo[2] . "-" .$meetingInfo[1] . "-" .$meetingInfo[0] . " " .$meetingInfo[3] . ":" .$meetingInfo[4] . ":" . $meetingInfo[5], ":event" => $meetingName));

  $statement = $connection->getConnection()->prepare("SELECT checkID FROM attendancecheck WHERE checktime = :checktime AND eventName = :event");
  $statement->execute(array(":checktime" => $meetingInfo[2] . "-" .$meetingInfo[1] . "-" .$meetingInfo[0] . " " .$meetingInfo[3] . ":" .$meetingInfo[4] . ":" . $meetingInfo[5], ":event" => $meetingName));

  $checkID = $statement->fetch(PDO::FETCH_ASSOC)['checkID'];


  for ($i=0; isset($people[$i]) ; $i++) { 
	$statement = $connection->getConnection()->prepare("SELECT username FROM users WHERE name = :name");
  	$statement->execute(array(":name" => trim($people[$i][0] . " " . $people[$i][1])));

  	$username = $statement->fetch(PDO::FETCH_ASSOC)['username'];

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

if (file_exists($filePath)) {
  echo "Sorry, file already exists.";
  return;
}


if($fileExtension != "txt" && $fileExtension != "csv") {
  echo "Sorry, only TXT and CSV files are allowed at the moment.";
  return;
}

  if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $filePath)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["uploadFile"]["name"])). " has been uploaded.";
    parseFile($filePath);
    return;

  } else {
    echo "Sorry, there was an error uploading your file.";
  }


?>
