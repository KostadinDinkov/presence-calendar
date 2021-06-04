
<
<?php

function uploadSchedule($file){

    $csv = array_map('str_getcsv', file($file));
    for($i = 0;$i<sizeof($csv);$i++){
    $startTime = $csv[1][0]. " ";
    $theme = $csv[1][3];
    echo $startTime . $theme;
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