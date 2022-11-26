<?php 
session_start();
error_reporting(-1);
ini_set('display_errors','On'); 

define('CONFIG_DIR',__DIR__.'/config');
require_once __DIR__.'/includes.php';

$userId = getCurrentUserId();
$products = getAllProducts();
var_dump($userId);
setcookie('userId',$userId,strtotime('+30 days'));

$cartItems = countProductsInCart($userId);

require __DIR__.'/templates/main.php';


