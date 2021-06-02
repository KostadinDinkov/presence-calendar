    <?php
      require_once 'db.php';

    $username = "62351";
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $repeatPassword = $_POST['repeatPassword'];

    if(empty($oldPassword) || empty($newPassword) || empty($repeatPassword)){
        echo "Попълнете всички полета. ";
        return;
    }
    if($newPassword != $repeatPassword){
        echo "Паролите не съвпадат. ";
        return ;   
    }
        $db = new Database('mysql','localhost','attendances','root',''); 
        $connection = $db->getConnection();
        $sql = 'SELECT pass FROM `users` WHERE username=?';
        $prepared = $connection->prepare($sql);
        $prepared->execute([$username]);
        $result = $prepared->fetch(PDO::FETCH_ASSOC)['pass'];
        
        if(!password_verify($oldPassword,$result)){
            echo "Грешна стара парола";
            return;    
        }
        
        $update="update users set pass=? WHERE username=?";
        $prepared = $connection->prepare($update);
        $hashed = password_hash($newPassword, PASSWORD_ARGON2ID);
        $prepared->execute([$hashed,$username]);
    
?>