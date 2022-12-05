<?php
$url = $_SERVER['REQUEST_URI'];
$indexPHPPosition = strpos($url,'index.php');
$route = substr($url,$indexPHPPosition);
$baseUrl = substr($url,0,$indexPHPPosition);

$route = null;
if(false !== $indexPHPPosition){
    $route = substr($url,$indexPHPPosition);
    $route = str_replace('index.php','',$route);
}

$userId = getCurrentUserId();
$countCartItems = countProductsInCart($userId);

if(!$route){
    $products = getAllProducts();
    require __DIR__.'/templates/main.php';
}

if(strpos($route,'/cart/add/')!==false){
    $routeParts = explode('/',$route);
    $productId = (int)$routeParts[3];
    addProductToCart($userId,$productId);
    header("Location:".$baseUrl."index.php");
    exit();
}

if(strpos($route,'/cart')!==false){
    $cartItems = getCartItemsForUserId($userId);
    $cartSum = getCartSumForUserId($userId);
    require __DIR__. '/templates/cartPage.php';
    exit();
}
if(strpos($route,'/login')!== false){
    $isPost = strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
    $username="";
    $password="";
    $errors=[];
    $hasErrors= false;
    if($isPost){
        $username= filter_input(INPUT_POST,'username');
        $password= filter_input(INPUT_POST,'password');

        if(false === (bool)$username){
            $errors[]="Username is empty";
        }
        if(false === (bool)$password){
            $errors[]="Password is empty";
        }
        $userData= getUserDataForUsername($username);
        if((bool)$username && 0===count($userData)){
            $errors[]="Username does not exisit";
        }
        if((bool)$password && isset($userData['password']) && false === password_verify($password,$userData['password'])){
            $errors [] ="Password is not valid.";
        } 
        if(0===count($errors)){
            $_SESSION['userId']=(int)$userData['id'];
            $redirectTarget = $baseUrl.'index.php';
            if(isset($_SESSION['redirectTarget'])){
                $redirectTarget =$_SESSION['redirectTarget'];
            }
            header("Location: ".$redirectTarget);
            var_dump($userData);
            exit();
        }
    }
    $hasErrors = count($errors) >0;
    require __DIR__. '/templates/login.php';
    exit();
}
if(strpos ($route, '/checkout') !== false) {
    if(!isLoggedIn()){
        $_SESSION['redirectTarget']=$baseUrl.'index.php/checkout';
        header("Location: ".$baseUrl."index.php/login");
        exit();
    }
    exit();
}
