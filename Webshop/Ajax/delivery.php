<?php

include('Databank.php');

if(isset($_POST["deliveryMethod"])){
    $sql="SELECT cost FROM delivery
        WHERE WHERE method='".$_POST["deliveryMethod"] ."'";

$result = mysqli_query($connect,$sql);
$result = mysqli_fetch_assoc($result);
echo $result;
}