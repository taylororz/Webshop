<?php
session_start();
include('Databank.php');
$message="";


if(!empty(($_SESSION['userId']))){
            $sql="SELECT login FROM user
                   Where login = 'Yes' 
            ";
     $result = mysqli_query($connect,$sql);
     $count = mysqli_num_rows($result);
     echo "Online user: $count ";
}