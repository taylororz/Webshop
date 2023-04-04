<?php
function getCurrentUserId():?int{
    $userId = null;


if(isset($_SESSION['userId'])){
    $userId = (int) $_SESSION['userId'];
}
return $userId;
}

function getUserDataForId(?int $userId):array{
    if(null === $userId){
        $userId = getCurrentUserId();
    }
    $sql="SELECT id,password,CONCAT_WS('-3100','KD',id) AS customerNr,firstname,lastLogin, activationKey,firstname,lastname,username
        FROM user where id=:id";

    $statement = getDB()->prepare($sql);
    if(false === $statement){
        return [];
    }
    $statement->execute([
        ':id'=>$userId
    ]);
    if (0 === $statement->rowCount()){
        return [];
    }
    $row = $statement->fetch();
    return $row;
}


function getUserDataForUsername(string $username):array{
    $sql="SELECT id,password,CONCAT_WS('-3100','KD',id) AS customerNr,firstname,lastLogin, activationKey,firstname,lastname,tag
        FROM user where username=:username";

    $statement = getDB()->prepare($sql);
    if(false === $statement){
        return [];
    }
    $statement->execute([
        ':username'=>$username
    ]);
    if (0 === $statement->rowCount()){
        return [];
    }
    $row = $statement->fetch();
    return $row;
}

function isLoggedIn(): bool
{
    return isset($_SESSION['userId']);

}

function userLogin($userId, $os,$resolution){
        $sql="UPDATE user SET
            login='Yes',
            os=:os,
            resolution=:resolution
            WHERE id=:userId";

        $statement = getDB()->prepare($sql);
        if(false === $statement){
            return false;
        }

        $statement->execute([
            ':userId'=>$userId,
            ':os'=>$os,
            ':resolution'=>$resolution
        ]);
        $affectedRows=$statement->rowCount();
        return $affectedRows > 0;    
    }


function createAccount(string $username,string $firstname,string $lastname):bool{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomPassword = '';
 
    for ($i = 0; $i < 9; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomPassword .= $characters[$index];
    }
    $activationKey = $randomPassword; 
    $password = hash('sha512', $activationKey);
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql="INSERT INTO user SET
            firstname=:firstname,
            lastname=:lastname,
            username=:username,
            activationKey=:activationKey,
            password=:password";

    $statement = getDB()->prepare($sql);
    if(false === $statement){
        return false;
    }

    $statement->execute([
        ':firstname'=>$firstname,
        ':lastname'=>$lastname,
        ':username'=>$username,
        ':activationKey'=>$activationKey,
        ':password'=>$password
    ]);
    $affectedRows=$statement->rowCount();
    return $affectedRows > 0;
}

function usernameExists(string $username):bool{
    $sql ="SELECT 1 FROM user WHERE username=:username";
    $statement = getDb()->prepare($sql);
    if(false === $statement){
      return false;
    }
    $statement->execute([
      ':username'=>$username
    ]);
    return (bool)$statement->fetchColumn();
  }

function getActivationLink(string $username):?string{
    $sql="SELECT activationKey FROM user 
        WHERE username=:username";
        $statement = getDB()->prepare($sql);
        if(false === $statement){
            return null;
        }
    $statement->execute([
        ':username'=>$username
    ]);
    if($statement->rowCount() === 0){
        return null;
    }    
    return $statement->fetchColumn();
}

function resetPassword(string $username):bool{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomPassword = '';
 
    for ($i = 0; $i < 9; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomPassword .= $characters[$index];
    }
    $activationKey = $randomPassword; 
    $password = hash('sha512', $activationKey);
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql="UPDATE user SET
            password=:password,
            activationKey=:activationKey,
            tag = NULL
            WHERE username=:username";

    $statement = getDB()->prepare($sql);
    if(false === $statement){
        return false;
    }

    $statement->execute([
        ':activationKey'=>$activationKey,
        ':username'=>$username,
        ':password'=>$password
    ]);
    $affectedRows=$statement->rowCount();
    return $affectedRows > 0;
}
    function setPassword(string $username, string $password):bool{
        $password = hash('sha512', $password);
        $password = password_hash($password, PASSWORD_DEFAULT);
        var_dump($password);
        $sql="UPDATE user SET
                password=:password,
                activationKey=null
            WHERE username=:username";
        $statement = getDB()->prepare($sql);
        if(false === $statement){
            return false;
        }
    
        $statement->execute([
            ':username'=>$username,
            ':password'=>$password
        ]);
        $affectedRows=$statement->rowCount();
        return $affectedRows > 0;
    };

    function userLogout(int $userId):bool{
        $sql="UPDATE user SET
            login='No'
            WHERE id=:userId";

        $statement = getDB()->prepare($sql);
        if(false === $statement){
            return false;
        }

        $statement->execute([
            ':userId'=>$userId,
        ]);
        setcookie("OS","", time()-1);
        setcookie("Resolution","", time()-1);
        $affectedRows=$statement->rowCount();
        return $affectedRows > 0;    
    }

    function checkUserTag($userId){
        $sql="SELECT tag FROM user 
                WHERE id=".$userId.";";

                $statement=getDB()->query($sql);
                return $statement->fetchColumn();
    }

    function activateTag($userId,$secret){
        $sql="UPDATE user SET
                tag=:secret
                WHERE id=".$userId.";";
        $statement = getDB()->prepare($sql);
        if(false === $statement){
            return false;
        }
        $statement->execute([
            ':secret'=>$secret
        ]);
        $affectedRows=$statement->rowCount();
        return $affectedRows > 0;    
    }

    function getUserIdwithUsername($username):int{
        $sql="SELECT id FROM user
            WHERE username='.$username.';";
             $statement=getDB()->query($sql);
                return $statement->fetch();
    }
    