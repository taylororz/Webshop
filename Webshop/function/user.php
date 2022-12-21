<?php
function getCurrentUserId():?int{
    $userId = null;


if(isset($_SESSION['userId'])){
    $userId = (int) $_SESSION['userId'];
}
return $userId;
}

function getUserDataForUsername(string $username):array{
    $sql="SELECT id,password FROM user where username=:username";

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