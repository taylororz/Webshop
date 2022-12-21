<?php
function getDB(){
    static $conn;
    if($conn instanceof PDO){
        return $conn;
    }
    require_once CONFIG_DIR.'/database.php';
    $dsn=sprintf("mysql:host=%s;dbname=%s;charset=%s",DB_HOST,DB_DATABASE,DB_CHARSET);
    $conn=new PDO($dsn,DB_USERNAME,DB_PASSWORD);
    return $conn;
}

function printDBErrorMessage(){
    $info = getDB()->errorInfo();
    if(isset($info[2])){
      return $info[2];
    }
    return '';
  }
