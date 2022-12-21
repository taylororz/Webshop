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


if(!$route){
    $products = getAllProducts();
    require __DIR__.'/templates/main.php';
    exit();
}

if(strpos($route,'/cart/add/')!==false){
    redirectIfNotLogged('/login');
    $routeParts = explode('/',$route);
    $productId = (int)$routeParts[3];
    $_SESSION['redirectTarget']=$baseUrl."index.php/cart/add/".$productId;
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

  $cartItems = getCartItemsForUserId($userId);
  $cartSum = getCartSumForUserId($userId);
  
  $firstname = "";
  $lastname= "";
  $address1 = "";
  $address2 = "";
  $country= "";
  $city= "";
  $zipCode = "";
  $isPost = isPost();
  $errors = [];
  $deliveryAddresses = getDeliveryAddressesForUser($userId);

  

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
    $city = filter_input(INPUT_POST,'city',FILTER_SANITIZE_SPECIAL_CHARS);
    $city=trim($city);
    $zipCode = filter_input(INPUT_POST,'zipCode',FILTER_SANITIZE_SPECIAL_CHARS);
    $zipCode=trim($zipCode);

    if(count($errors)===0){
      $saveAddressForUser=saveAddressForUser($userId,$firstname,$lastname,$address1,$address2,$country,$city,$zipCode);
      if($deliveryAddressId > 0){
        $_SESSION['deliveryAddressId'] = $deliveryAddressId;
        header("Location: ".$baseUrl."index.php/success");
        exit();
      }
     
     $errors[]="Invalid address";
    }
   }

   $hasErrors = count($errors) > 0;

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

if(strpos($route,'/success') !== false){
  redirectIfNotLogged('/checkout');
  
  $routeParts = explode('/',$route);
  $deliveryAddressId = (int)$routeParts[2];
  $_SESSION['deliveryAddressId'] = $deliveryAddressId;

  $userId=getCurrentUserId();
  $cartItems = getCartItemsForUserId($userId);
  $deliveryAddressFields=getAddressForUser($_SESSION['deliveryAddressId'],$userId);

  if(createOrder($userId,$cartItems,$deliveryAddressFields)){
    clearCartForUser($userId);
    require __DIR__ .'/templates/thankyou.php';
    exit();
  }
}


if(strpos($route,'/invoice') !== false){
  redirectIfNotLogged('/');
  $routeParts = explode('/',$route);
  $invoiceId = null;
  if(isset($routeParts[2])){
    $invoiceId=(int)$routeParts[2];
  }
  if(!$invoiceId){
    echo "You don't have order.";
    exit();
  }
  $userId = getCurrentUserId();
  $orderData = getOrderForUser($invoiceId,$userId);
  
  if(!$orderData){
    echo "We don't find your data here.";
    exit();
  }
  require __DIR__ .'/templates/invoice.php';
  exit();
}