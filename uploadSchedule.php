
<
<?php

function uploadSchedule($file){

    $csv = array_map('str_getcsv', file($file));
    $eventTime = explode(' ',$csv[0][1])[1];
    $date = explode('.',$eventTime);
    echo $date[0];
    echo $date[1];
    echo $date[2];
    


}

$uploadDir = "uploads/";
$filePath = $uploadDir . basename($_FILES["uploadFile"]["name"]);
$fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

if($fileExtension != "txt" && $fileExtension != "csv") {
  echo "Sorry, only TXT and CSV files are allowed at the moment.";
  return;
}

  if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $filePath)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["uploadFile"]["name"])). " has been uploaded.";
    uploadSchedule($filePath);
    return;

  } else {
    echo "Sorry, there was an error uploading your file.";
  }


?>