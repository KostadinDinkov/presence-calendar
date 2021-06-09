
<?php

  require_once 'db.php';
 
  function uploadSchedule($file){

    $db = new Database('mysql','localhost','attendances','root',''); 
    $connection = $db->getConnection();
    $csv = array_map('str_getcsv', file($file));
    $eventTopic = $_POST['topic'];
    $date = $_POST['eventDate'];

    $insert = 'insert into events(courseID,topic,eventDate) values(?,?,?)';
    $statement = $connection->prepare($insert);
    $statement->execute([$_GET['id'],$eventTopic,$date]);

    $select = 'select id from events where topic=? and eventDate=?';
    $statement = $connection->prepare($select);
    $statement->execute([$eventTopic,$date]);
    $eventID = $statement->fetch(PDO::FETCH_ASSOC)['id'];
  
    for($i = 0;$i<sizeof($csv)-2;$i++){
      
      if(count($csv[$i+1])>=4){
        
        $startTime = $csv[$i+1][0];
        $endTime = $csv[$i+2][0];
        $topic=implode(', ',array_slice($csv[$i+1],3,count($csv[$i+1])-2));
   
        $sql = 'insert into subevents(eventID,startTime,endTime,topic) values(?,?,?,?)';
        $statement = $connection->prepare($sql);
        $statement->execute([$eventID,$date . " ". $startTime . ":00",$date . " ". $endTime . ":00",$topic]);
]
    }else{
        $startTime = $csv[$i+1][0];
    }
  }
    
}
$uploadDir = "uploads/";
$filePath = $uploadDir . basename($_FILES["uploadFile"]["name"]);
$fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

if($fileExtension != "txt" && $fileExtension != "csv") {
  echo "Sorry, only TXT and CSV files are allowed at the moment.";
  echo "<br/>";
  return;
}

  if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $filePath)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["uploadFile"]["name"])). " has been uploaded.";
    echo "<br/>";
    uploadSchedule($filePath);
    return;

  } else {
    echo "Sorry, there was an error uploading your file.";
    echo "<br/>";
  }


?>