<?php
session_start();
include('Databank.php');
$userId=$_SESSION['userId'];


if(($_POST["quantity"])){
    $sql = "UPDATE `shopping cart`
    SET quantity = '".$_POST["quantity"]."'
    WHERE user_id= '".$userId."' AND product_id=2";
    $result = mysqli_query($connect,$sql);
}
