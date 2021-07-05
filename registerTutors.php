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
}

  if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $filePath)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["uploadFile"]["name"])). " has been uploaded.";
    readTutors($filePath);

  } else {
    echo "Sorry, there was an error uploading your file.";
  }


?>

<?php
    function addTutor($line,$connection){

        $array = preg_split('/[\t]/', $line);
            
        $name = $array[0];
        $faculty = $array[1];
        $email = $array[2];
        $username = explode('@',$email)[0];
        $password = password_hash($username, PASSWORD_ARGON2ID);
        $sql = 'INSERT INTO `users` (`email`, `name`, `username`,`faculty`, `pass`,`role`) VALUES (?, ?,?, ?, ?, ?);';
        $prepared = $connection->prepare($sql);
        $prepared->execute([$email,$name,$username,$faculty,$password,"tutor"]);


    }

    function readTutors($file){
  
        require_once('db.php');
        $db = new Database(); 
        $connection = $db->getConnection();
        $handle = fopen($file, "r");
        if ($handle) {
            
            while (!feof($handle)) {
                $line = trim(fgets($handle));
                if($line!=''){
                    addTutor($line,$connection);
            }
        }
            fclose($handle);
        } else {
            echo "error while opening file";
        } 

    }

    header('Location: upload.php');

?>


