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
    $sql="SELECT id,password,CONCAT_WS('-3100','KD',id) AS customerNr
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
    $sql="SELECT id,password,CONCAT_WS('-3100','KD',id) AS customerNr, activationKey
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

function createAccount(string $username):bool{
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
            username=:username,
            activationKey=:activationKey,
            password=:password";

    $statement = getDB()->prepare($sql);
    if(false === $statement){
        return false;
    }

    $statement->execute([
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

function activateAccount(string $username,string $activationKey):bool{
    $sql="UPDATE user
        SET activationKey= NULL 
        WHERE username=:username AND activationKey=:activationKey";
        $statement = getDB()->prepare($sql);
        if(false === $statement){
            return false;
        }
        $statement -> execute([
            ':username'=>$username,
            ':activationKey'=>$activationKey
        ]);
        $affectedRows=$statement->rowCount();
        return $affectedRows>0;
}

function getActivationLink(string $username):?string{
    $sql="SELECT activationKey,activity FROM user 
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