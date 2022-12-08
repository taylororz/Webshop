<?php
$url = $_SERVER['REQUEST_URI'];
$indexPHPPosition = strpos($url,'index.php');
$baseUrl=$url;

if(false!== $indexPHPPosition){
    $baseUrl=substr($baseUrl,0,$indexPHPPosition);
}

if(substr($baseUrl,-1)!=='/'){
    $baseUrl .='/';
}

$route = null;

if(false !== $indexPHPPosition){
    $route = substr($url,$indexPHPPosition);
    $route = str_replace('index.php','',$route);
}

$userId = getCurrentUserId();
$countCartItems = countProductsInCart($userId);

setcookie('userId',$userId,strtotime('+30 days'),$baseUrl);

if(!$route){
    $products = getAllProducts();
    require __DIR__.'/templates/main.php';
    exit();
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
    $isPost = isPost();
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
        if(0 === count($errors)){
            $_SESSION['userId']=(int)$userData['id'];
            moveCartProductsToAnotherUser($_COOKIE['userId'],(int)$userData['id']);
            $redirectTarget = $baseUrl.'index.php';
            if(isset($_SESSION['redirectTarget'])){
              $redirectTarget = $_SESSION['redirectTarget'];
            }
            header("Location: ". $redirectTarget);
            exit();
        }
          }
    
    $hasErrors = count($errors) > 0;
    require __DIR__. '/templates/login.php';
    exit();
}
if(strpos ($route, '/checkout') !== false) {
    if(!isLoggedIn()){
        header("Location: ".$baseUrl."index.php/login");
        exit();
    }
    
    require __DIR__. '/templates/selectDeliveryAddress.php';
    exit();
}

if(strpos($route,'/logout') !== false){
    session_regenerate_id(true);
    session_destroy();
    $redirectTarget = $baseUrl.'index.php';
    if(isset($_SESSION['redirectTarget'])){
        $redirectTarget = $_SESSION['redirectTarget'];
    }
    header("Location: ". $redirectTarget);
    exit();
}

if(strpos($route,'/address/add') !== false){
    if(false === isLoggedIn()){
        $_SESSION['redirectTarget'] = $baseUrl.'index.php/address/add';
        header("Location: ".$baseUrl."index.php/login");
        exit();
    }
    
    $recipient="";
    $street="";
    $streetNr="";
    $city="";
    $zipCode="";
    $isPost = isPost();
    $errors=[];
    if($isPost){
        $recipient = filter_input(INPUT_POST,'recipient');
        $street = filter_input(INPUT_POST,'street');
        $streetNr = filter_input(INPUT_POST,'streetNr');
        $city = filter_input(INPUT_POST,'city');
        $zipCode = filter_input(INPUT_POST,'zipCode');

        if(!$recipient){
            $errors[]="Bitte Empfänger eintragen";
        }
        if(!$street){
            $errors[]="Bitte Straße eintragen";
        }
        if(!$streetNr){
            $errors[]="Bitte Hausnummer eintragen";
        }
        if(!$city){
            $errors[]="Bitte Stadt eintragen";
        }
        if(!$zipCode){
            $errors[]="Bitte PLZ eintragen";
        }
    }
    $hasErrors = count($errors) > 0;
    

    require __DIR__.'/templates/selectDeliveryAddress.php';
    exit();
}


