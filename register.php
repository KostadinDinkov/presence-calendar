<?php

    
    require_once('db.php');
    $db = new Database('mysql','localhost','attendances','root',''); 
    $connection = $db->getConnection();
    $tutors = "db/tutors.txt";
    readTutors($tutors,$connection);
    readStudents($file,$connection);
    
    function addStudent($line,$connection){
        $array = preg_split('/[\t]/', $line);
            
        $fn =  $array[0] ;
        $name = $array[1];
        $faculty = $array[2];
        $specialty = explode('(',$array[3])[0];
        $year = $array[4];
        $group = $array[5];
        $email = $array[6];
        $username = $fn;
        $password = password_hash($fn, PASSWORD_ARGON2ID);
        $sql = 'INSERT INTO `users` (`fn`, `email`, `name`, `username`, `year`, `yeargroup`,`faculty`, `spec`, `pass`,`role`) VALUES (?, ?,?, ?, ?, ?, ?, ?, ?,?);';
        $prepared = $connection->prepare($sql);
        $prepared->execute([$fn,$email,$name,$username,$year,$group,$faculty,$specialty,$password,"student"]);


    }

    function addTutor($line,$connection){

        $array = preg_split('/[\t]/', $line);
            
        $name = $array[0];
        $email = $array[3];
        $username = $name;
        $password = password_hash($name, PASSWORD_ARGON2ID);
        $sql = 'INSERT INTO `users` (`email`, `name`, `username`,`faculty`, `pass`,`role`) VALUES (?, ?,?, ?, ?, ?);';
        $prepared = $connection->prepare($sql);
        $prepared->execute([$email,$name,$username,$faculty,$password,"tutor"]);


    }

    function readTutors($tutors,$connection){
        
        $handle = fopen($file, "r");
        if ($handle) {
            
            $line = fgets($handle);
            while (!feof($handle)) {
                $line = trim(fgets($handle));
                if($line!=''){
                    addTutorTODB($line,$connection);
            }
        }
            fclose($handle);
        } else {
            echo "error while opening file";
        } 

    }

    function readStudents($file){
        
        require_once('db.php');
        $db = new Database('mysql','localhost','attendances','root',''); 
        $connection = $db->getConnection();

        $handle = fopen($file, "r");
        if ($handle) {
            
            $line = fgets($handle);
            while (!feof($handle)) {
                $line = trim(fgets($handle));
                if($line!=''){
                    addStudent($line,$connection);
            }
        }
            fclose($handle);
        } else {
            echo "error while opening file";
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
    readStudents($filePath);
    return;

  } else {
    echo "Sorry, there was an error uploading your file.";
  }


?>

