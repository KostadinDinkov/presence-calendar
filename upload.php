<?php
  require("./security.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>

<form action="registerTutors.php" method="post" enctype="multipart/form-data">
  <input type="file" name="uploadFile" id="fileToUpload">
  <button id="parseButton">Качи файл с преповадатели</button>
</form>

<form action="registerStudents.php" method="post" enctype="multipart/form-data">
  <input type="file" name="uploadFile" id="fileToUpload">
  <button id="parseButton">Качи файл със студенти</button>
</form>

<nav>
    <p>Влезли сте в системата като: 
        <span style="color:#f8f5f0;"><?php echo $_SESSION['name'] ?></span> <a href="login.php">(Изход)</a> </p>
    <p></p>
</nav>

</body>
</html>


