<?php

include('Databank.php');

if(!empty($_POST["username"])){
    $sql = "SELECT * FROM user WHERE username='".$_POST["username"] ."'";
    $result = mysqli_query($connect,$sql);
    $count = mysqli_num_rows($result);
    if($count>0){
        echo "<span style='color:red'> User already exists.</span>";
    }else{
        echo "<span style='color:green'> User avaliable. </span>";
    }
}  
