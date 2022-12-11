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

define('BASE_URL',$baseUrl);

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

if(strpos($route,'/checkout')!==false){
  redirectIfNotLogged('/checkout');
  $cartItems = getCartItemsForUserId($userId);
  $cartSum = getCartSumForUserId($userId);
  require __DIR__. '/templates/checkout.php';
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
if(strpos($route,'/checkout') !== false){
  redirectIfNotLogged('/checkout');
  
  $firstname = "";
  $lastname= "";
  $address1 = "";
  $address2 = "";
  $country= "";
  $states= "";
  $zipCode = "";
  $isPost = isPost();
  $errors = [];
  

  if($isPost){
    $firstname = filter_input(INPUT_POST,'firstname',FILTER_SANITIZE_SPECIAL_CHARS);
    $firstname=trim($firstname);
    $lastname = filter_input(INPUT_POST,'lastname',FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname=trim($lastname);
    $address1 = filter_input(INPUT_POST,'address1',FILTER_SANITIZE_SPECIAL_CHARS);
    $address1=trim($address1);
    $address2 = filter_input(INPUT_POST,'address2',FILTER_SANITIZE_SPECIAL_CHARS);
    $address2=trim($address2);
    $country = filter_input(INPUT_POST,'country',FILTER_SANITIZE_SPECIAL_CHARS);
    $country=trim($country);
    $states = filter_input(INPUT_POST,'states',FILTER_SANITIZE_SPECIAL_CHARS);
    $states=trim($states);
    $zipCode = filter_input(INPUT_POST,'zipCode',FILTER_SANITIZE_SPECIAL_CHARS);
    $zipCode=trim($zipCode);

    if(count($errors)===0){
      $saveAddressForUser=saveAddressForUser($userId,$firstname,$lastname,$address1,$address2,$country,$states,$zipCode);
      if($saveAddressForUser > 0){
      $_SESSION['saveAddressForUser']=$saveAddressForUser;
        header("Location: ".$baseUrl."index.php/success");
        exit();
     }
     $errors[]="Invalid address";
    }
   }
  require __DIR__ .'/templates/checkout.php';
  exit();
   }


   if(strpos($route,'/logout') !== false){
    $redirectTarget = $baseUrl.'index.php';
    if(isset($_SESSION['redirectTarget'])){
      $redirectTarget = $_SESSION['redirectTarget'];
    }
    session_regenerate_id(true);
    session_destroy();
    header("Location: ".$redirectTarget);
    exit();
  }


if(strpos($route,'/checkout/susscess') !== false){
  redirectIfNotLogged('/checkout/susscess');
    
   
}
