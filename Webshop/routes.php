<?php
setcookie('PHPSESSID', ", time()-1,'/', ", 0, 0);
require_once __DIR__ . '/vendor/autoload.php';


$url = $_SERVER['REQUEST_URI'];
$indexPHPPosition = strpos($url, 'index.php');
$baseUrl = $url;
$isEmail = false;

if (false !== $indexPHPPosition) {
  $baseUrl = substr($baseUrl, 0, $indexPHPPosition);
}

if (substr($baseUrl, -1) !== '/') {
  $baseUrl .= '/';
}

define('BASE_URL', $baseUrl);
$projectUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $baseUrl;

$route = null;

if (false !== $indexPHPPosition) {
  $route = substr($url, $indexPHPPosition);
  $route = str_replace('index.php', '', $route);
}

$userId = getCurrentUserId();
$countCartItems = countProductsInCart($userId);


if (!$route) {
  $products = getAllProducts();
  $flashMessage = flashMessage();
  $hasFlashMessage = count($flashMessage) > 0;
  require __DIR__ . '/templates/main.php';
  exit();
}

if (strpos($route, '/cart/add/') !== false) {
  redirectIfNotLogged('/login');
  $routeParts = explode('/', $route);
  $productId = (int)$routeParts[3];
  $isPost = isPost();
  if (isPost()) {
    $quantity = filter_input(INPUT_POST, 'quantity');
    $_SESSION['redirectTarget'] = $baseUrl . "index.php/cart/add/" . $productId;
    addProductToCart($userId, $productId, $quantity);
    header("Location:" . $baseUrl . "index.php");
  }
  exit();
}

if (strpos($route, '/cart/delete/') !== false) {
  redirectIfNotLogged('/login');
  $userId = getCurrentUserId();
  $routeParts = explode('/', $route);
  $productId = (int)$routeParts[3];

  $_SESSION['redirectTarget'] = $baseUrl . "index.php/cart/delete/" . $productId;
  deleteProductInCartForUserId($userId, $productId);
  header("Location:" . $baseUrl . "index.php/cart");
  exit();
}

if (strpos($route, '/cart/change/') !== false) {
  redirectIfNotLogged('/login');
  $userId = getCurrentUserId();
  $routeParts = explode('/', $route);
  $productId = (int)$routeParts[3];
  $isPost = isPost();
  if (isPost()) {
    $quantity = filter_input(INPUT_POST, 'addcart');
    changeCart($userId, $productId, $quantity);
    header("Location:" . $baseUrl . "index.php/cart");
    exit();
  }
}


if (strpos($route, '/cart') !== false) {
  $cartItems = getCartItemsForUserId($userId);
  $flashMessage = flashMessage();
  $hasFlashMessage = count($flashMessage) > 0;
  $cartSum = getCartSumForUserId($userId);
  $cartOrignalSum = getOriginalCartSumForUserId($userId);

  require __DIR__ . '/templates/cartPage.php';
  exit();
}


if (strpos($route, '/login') !== false) {

  $isPost = isPost();
  $userId = "";
  $username = "";
  $password = "";
  $errors = [];
  $hasErrors = false;


  if (getCurrentUserId() !== null) {
    header("Location: " . $baseUrl . "index.php");
  } else {
    if ($isPost) {
      $username = filter_input(INPUT_POST, 'username');
      $password = filter_input(INPUT_POST, 'password');

      if (false === (bool)$username) {
        $errors[] = "Username is empty";
      }
      if (false === (bool)$password) {
        $errors[] = "Password is empty";
      }
      $userData = getUserDataForUsername($username);

      if ((bool)$username && 0 === count($userData)) {
        $errors[] = "Username does not exisit";
      }
      if ((bool)$username && isset($userData['activationKey']) && false === is_null($userData['activationKey'])) {
        $activationLink = $projectUrl . 'index.php/account/setPassword/' . $username . '/' . $activationKey;
        header("Location: " . $activationLink);
        exit();
      }
      if ((bool)$password && isset($userData['password']) && false === password_verify(hash('sha512', $password), $userData['password'])) {
        $errors[] = "Password is not valid.";
      }
      if (0 === count($errors)) {
        $checkTag = checkUserTag((int)$userData['id']);
        $resolution = $_COOKIE['Resolution'];
        $os = $_COOKIE['OS'];
        userLogin($_SESSION['userId'], $os, $resolution);


        if ($checkTag === NULL) {

          flashMessage("You account is not secured, please activate Google Authenticator.");
          header("Location: " . $baseUrl . "index.php/tagactive/".$username);
        } else {
          flashMessage("Please verify with Google Authenticator!");
          header("Location: " . $baseUrl . "index.php/verify/".$username);
        }

        exit();
      }
    }
  }
  $hasErrors = count($errors) > 0;
  require __DIR__ . '/templates/login.php';
  exit();
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


if (strpos($route, '/logout') !== false) {
  $userId = getCurrentUserId();
  userLogout($userId);
  $redirectTarget = $baseUrl . 'index.php';
  if (isset($_SESSION['redirectTarget'])) {
    $redirectTarget = $_SESSION['redirectTarget'];
  }
  session_regenerate_id(true);
  session_destroy();
  header("Location: " . $baseUrl . "index.php");
  exit();
}

if (strpos($route, '/success') !== false) {
  redirectIfNotLogged('/checkout');
  require __DIR__ . '/templates/thankyou.php';
  exit();
}



if (strpos($route, '/invoice') !== false) {
  $routeParts = explode('/', $route);
  $userId = $routeParts[2];
  $orderId = $routeParts[3];
  $deliveryMethod = getDeliverymethod($orderId);
  $getData = getSingleOrderForUser($orderId, $userId);
  $getAddressFromUser = $getData['deliveryAddressFields'];
  $orderData = getOrderDetail($orderId);
  $deliveryMethod = getDeliverymethod($orderId);
  $getSum = getSumForOrder($orderId, $userId);
  $getSumNetto = getOrderSumForUser($orderId, $userId);

  $isEmail = true;

  if (!$orderId) {
    echo "You don't have order.";
    exit();
  }
  $orderData = getSingleOrderForUser($orderId, $userId);
  $userData = getUserDataForId($userId);
  $orderSum = getOrderSumForUser($orderId, $userId);
  $getNewOrderId = getOrderId($userId);


  if (!$orderData) {
    echo "We don't find your data here.";
    exit();
  }
  require __DIR__ . '/templates/invoiceEmail.php';
  exit();
}



require '/Applications/XAMPP/xamppfiles/htdocs/Webshop/Webshop/PHPMailer/includes/Exception.php';
require '/Applications/XAMPP/xamppfiles/htdocs/Webshop/Webshop/PHPMailer/includes/PHPMailer.php';
require '/Applications/XAMPP/xamppfiles/htdocs/Webshop/Webshop/PHPMailer/includes/SMTP.php';

if (strpos($route, '/registration') !== false) {
  $firstname = "";
  $lastname = "";
  $username = "";
  $usernameRepeat = "";
  $password = "";
  $onetime_pw = "";
  $errors = [];

  if (isPost()) {
    $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
    $usernameRepeat = filter_input(INPUT_POST, 'usernameRepeat', FILTER_SANITIZE_EMAIL);

    if (false === (bool)$firstname) {
      $errors[] = "Firstname is empty";
    }
    if (false === (bool)$lastname) {
      $errors[] = "Lastname is empty";
    }

    if (false === (bool)$username) {
      $errors[] = "Username is empty";
    }
    if (true === (bool)$username) {

      if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Username is not valid";
      }
      $usernameExists = usernameExists($username);
      if (true === $usernameExists) {
        $errors[] = "Username already exists";
      }
    }
    if ($username !== $usernameRepeat) {
      $errors[] = "Username do not match to above username";
    }

    $hasErrors = count($errors) > 0;
    if (false === $hasErrors) {
      $created = createAccount($username, $firstname, $lastname);
      if (!$created) {
        $errors[] = "Account could not be created, try again later";
      }
      if ($created) {
        $activationLink = $projectUrl . 'index.php/activationMail/' . $username;
        $mail = new PHPMailer("Thank you for registration");
        $mail->isSMTP();
        $mail->CharSet = "UTF-8";
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = "true";
        $mail->SMTPSecure = "tls";
        $mail->Port = "587";
        $mail->Username = "myshopebike@gmail.com";
        $mail->Password = "";
        $mail->isHTML(true);
        $mail->Body = file_get_contents($activationLink);
        $mail->Subject = "Activation";
        $mail->SetFrom('noreply@myshop.com', 'Myshop');
        $mail->addAddress($username);
        if ($mail->send()) {
          $errors[] = "Something went wrong.";
        }
        flashMessage("Account has been created, but you need to active it. Please check you Email");
        header("Location: " . $baseUrl . "index.php");
      }
    }
  }
  $hasErrors = count($errors) > 0;
  require __DIR__ . '/templates/registration.php';
  exit();
}

if (strpos($route, '/account/setPassword') !== false) {
  $routeParts = explode('/', $route);
  $password = "";
  $username = "";
  $passwordRepeat = "";
  $username = $routeParts[3];
  $errors = [];

  if (isPost()) {
    $password = filter_input(INPUT_POST, 'password');
    $passwordRepeat = filter_input(INPUT_POST, 'passwordRepeat');

    if (false === (bool)$password) {
      $errors[] = "Password is empty";
    }

    if (true === (bool)$password) {
      if ($password !== $passwordRepeat) {
        $errors[] = "Password doesn't match";
      }
    }
    if ($password === $passwordRepeat) {
      $set = setPassword($username, $password);
      if (!$set) {
        $errors[] = "Something went wrong, try again later";
      }
      if ($set) {
        flashMessage("You account is set. You can login now.");
        header("Location: " . $baseUrl . "index.php");
      }
    }
  }
  $hasErrors = count($errors) > 0;
  require __DIR__ . '/templates/setPassword.php';
}

if (strpos($route, '/activationMail') !== false) {
  $routeParts = explode('/', $route);
  if (count($routeParts) !== 3) {
    echo "Invalid URL!";
    exit();
  }
  $username = $routeParts[2];
  $activationKey = getActivationLink($username);
  if (null === $activationKey) {
    echo "Account is activated.";
    exit();
  }
  $name = getUserDataForUsername($username);
  $activity = date('d.M.Y');
  $activationLink = $projectUrl . 'index.php/account/setPassword/' . $username . '/' . $activationKey;
  $isEmail = true;
  require_once __DIR__ . '/templates/activationMail.php';
  exit();
}

if (strpos($route, '/product') !== false) {
  $routeParts = explode('/', $route);
  if (count($routeParts) !== 3) {
    echo "Invalid URL!";
    exit();
  }
  $slug = $routeParts[2];
  if (0 === strlen(($slug))) {
    echo "Invalid product!";
  }
  $product = getProductsBySlug($slug);
  require_once __DIR__ . '/templates/productDetails.php';
  exit();
}

if (strpos($route, '/resetpw') !== false) {
  $username = "";
  $errors = [];


  if (isPost()) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_EMAIL);
    if (false === (bool)$username) {
      $errors[] = "Username is empty";
    }

    if (true === (bool)$username) {
      if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Username is not valid";
      }
      $usernameExists = usernameExists($username);
      if (true === $usernameExists && true === resetPassword($username)) {
        $name = getUserDataForUsername($username);
        $activationLink = $projectUrl . 'index.php/resetMail/' . $username;
        $mail = new PHPMailer("You request a reset of password.");
        $mail->isSMTP();
        $mail->CharSet = "UTF-8";
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = "true";
        $mail->SMTPSecure = "tls";
        $mail->Port = "587";
        $mail->Username = "";
        $mail->Password = "";
        $mail->isHTML(true);
        $mail->Body = file_get_contents($activationLink);
        $mail->Subject = "Password reset";
        $mail->SetFrom('noreply@myshop.com', 'Myshop');
        $mail->addAddress($username);
        if ($mail->send()) {
          $errors[] = "Something went wrong.";
        }
        flashMessage("Account has been reset, but you need to set new password. Please check you Email");
        header("Location: " . $baseUrl . "index.php");
      }
    }
  }
  $hasErrors = count($errors) > 0;
  require __DIR__ . '/templates/resetPw.php';
  exit();
}

if (strpos($route, '/resetMail') !== false) {
  $routeParts = explode('/', $route);
  if (count($routeParts) !== 3) {
    echo "Invalid URL!";
    exit();
  }
  $username = $routeParts[2];
  $activationKey = getActivationLink($username);
  if (null === $activationKey) {
    echo "Account is activated.";
    exit();
  }
  $name = getUserDataForUsername($username);
  $activity = date('d.M.Y');
  $activationLink = $projectUrl . 'index.php/account/setPassword/' . $username . '/' . $activationKey;
  $isEmail = true;
  require_once __DIR__ . '/templates/resetMail.php';
  exit();
}

if (strpos($route, '/myOrder/again') !== false) {
  redirectIfNotLogged('/login');
  $routeParts = explode('/', $route);
  $orderId = $routeParts[4];
  $userId = $routeParts[3];
  $userId = getCurrentUserId();
  $username = getUserDataForId($userId);
  $getData = getOrderForUserwithoutDate($orderId, $userId);

  $rebuy = orderAgain($userId, $getData);

  if ($rebuy) {
    $invoiceLink = $projectUrl . 'index.php/invoiceEmail/' . $userId . '/' . $orderId;
    $mail = new PHPMailer("Thank you for your order again!");
    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = "true";
    $mail->SMTPSecure = "tls";
    $mail->Port = "587";
    $mail->Username = "myshopebike@gmail.com";
    $mail->Password = "";
    $mail->isHTML(true);
    $mail->Body = file_get_contents($invoiceLink);
    $mail->Subject = "Thank you for your order!";
    $mail->SetFrom('noreply@myshop.com', 'Myshop');
    $mail->addAddress($username['username']);
    if ($mail->send()) {
      $errors[] = "Something went wrong.";
    }
    header("Location: " . $baseUrl . "index.php/success");
    exit();
  }
  require __DIR__ . '/templates/thankyou.php';

  exit();
}

if (strpos($route, '/myOrderDetail') !== false) {
  redirectIfNotLogged('/login');
  $routeParts = explode('/', $route);
  $orderId = $routeParts[3];
  $userId = $routeParts[2];
  $orderData = getOrderDetail($orderId);
  $deliveryMethod = getDeliverymethod($orderId);
  $getSum = getSumForOrder($orderId, $userId);
  $getSumNetto = getOrderSumForUser($orderId, $userId);


  require_once __DIR__ . '/templates/myOrderDetail.php';
  exit();
}


if (strpos($route, '/myOrder') !== false) {
  redirectIfNotLogged('/login');
  $routeParts = explode('/', $route);
  $userId = getCurrentUserId();
  $orderId = getOrderNrforUser($userId);


  require_once __DIR__ . '/templates/myOrder.php';
  exit();
}


if (strpos($route, '/checkout') !== false) {
  redirectIfNotLogged('/checkout');


  $cartItems = getCartItemsForUserId($userId);
  $cartSum = getCartSumForUserId($userId);
  $cartOrignalSum = getOriginalCartSumForUserId($userId);
  $username = getUserDataForId($userId);


  $firstname = "";
  $lastname = "";
  $address1 = "";
  $address2 = "";
  $country = "";
  $city = "";
  $zipCode = "";
  $deliveryId = "";
  $isPost = isPost();
  $errors = [];
  if (empty($cartItems)) {
    header("Location:" . $baseUrl . "index.php/cart");
  }


  if ($isPost) {
    $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS);
    $firstname = trim($firstname);
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = trim($lastname);
    $address1 = filter_input(INPUT_POST, 'address1', FILTER_SANITIZE_SPECIAL_CHARS);
    $address1 = trim($address1);
    $address2 = filter_input(INPUT_POST, 'address2', FILTER_SANITIZE_SPECIAL_CHARS);
    $address2 = trim($address2);
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_SPECIAL_CHARS);
    $country = trim($country);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS);
    $city = trim($city);
    $zipCode = filter_input(INPUT_POST, 'zipCode', FILTER_SANITIZE_SPECIAL_CHARS);
    $zipCode = trim($zipCode);
    $deliveryId = $_POST['deliveryMethod'];




    if (count($errors) === 0) {
      $createdOrder = createOrder($userId, $cartItems, $firstname, $lastname, $address1, $address2, $country, $city, $zipCode, $deliveryId);
      clearCartForUser($userId);
      $orderId = getOrderId($userId);
      if ($createdOrder === true) {
        $invoiceLink = $projectUrl . 'index.php/invoiceEmail/' . $userId . '/' . $orderId;
        $mail = new PHPMailer("Thank you for your order!");
        $mail->isSMTP();
        $mail->CharSet = "UTF-8";
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = "true";
        $mail->SMTPSecure = "tls";
        $mail->Port = "587";
        $mail->Username = "myshopebike@gmail.com";
        $mail->Password = "";
        $mail->isHTML(true);
        $mail->Body = file_get_contents($invoiceLink);
        $mail->Subject = "Thank you for your order!";
        $mail->SetFrom('noreply@myshop.com', 'Myshop');
        $mail->addAddress($username['username']);
        if ($mail->send()) {
          $errors[] = "Something went wrong.";
        }
      }
      header("Location: " . $baseUrl . "index.php/success");
      exit();
    } else {
      echo "something went wrong";
    }

    $errors[] = "Invalid address";
  }


  $hasErrors = count($errors) > 0;

  require __DIR__ . '/templates/checkout.php';
  exit();
}

if (strpos($route, '/tagactive') !== false) {
  $otp = "";
  $routeParts = explode('/', $route);
  $username = $routeParts[2];
  $userData = getUserDataForUsername($username);
  $userId=$userData['id'];
  $flashMessage = flashMessage();
  $hasFlashMessage = count($flashMessage) > 0;
  $ga = new PHPGangsta_GoogleAuthenticator();
  $errors = [];
  $hasErrors = false;
  $isPost = isPost();
  $resolution = $_COOKIE['Resolution'];
  $os = $_COOKIE['OS'];
  $checkTag = checkUserTag($userId);

  if ($checkTag === NULL) {
    $secret = $ga->createSecret();
    $uploadSecret = activateTag($userId, $secret);
    $qrCodeUrl = $ga->getQRCodeGoogleUrl('Myshop', $secret);
  } else {
    $qrCodeUrl = $ga->getQRCodeGoogleUrl('Myshop', $checkTag);
    $oneCode = $ga->getCode($checkTag);

  }


  if (isPost()) {
    $otp = filter_input(INPUT_POST, 'otp');
    $checkResult = $ga->verifyCode($checkTag, $otp, 2);
    if (false === (bool)$otp) {
      $errors[] = "OTP is empty";
    }

    if ((bool)$otp && false === $checkResult) {
      $errors[] = "OTP is wrong";
    }
    $userData = getUserDataForId($userId);
    if (0 === count($errors)) {
      if ($checkResult) {

        $_SESSION['userId']=$userId;
        userLogin($userId,$os,$resolution);

        $redirectTarget = $baseUrl . 'index.php';
        if (isset($_SESSION['redirectTarget'])) {
          $redirectTarget = $_SESSION['redirectTarget'];
        }
        flashMessage("Welcome $userData[firstname], you logged in last time on $userData[lastLogin]");
        
        header("Location: " . $baseUrl . "index.php");
      }
    }
  }
  $hasErrors = count($errors) > 0;
  require __DIR__ . '/templates/activation.php';
  exit();
}



if (strpos($route, '/verify') !== false) {
  $otp = "";
  $routeParts = explode('/', $route);
  $username = $routeParts[2];
  $userData = getUserDataForUsername($username);
  $userId=$userData['id'];
  $flashMessage = flashMessage();
  $hasFlashMessage = count($flashMessage) > 0;
  $ga = new PHPGangsta_GoogleAuthenticator();
  $errors = [];
  $hasErrors = false;
  $isPost = isPost();
  $checkTag = checkUserTag($userId);
  $resolution = $_COOKIE['Resolution'];
  $os = $_COOKIE['OS'];
  $qrCodeUrl = $ga->getQRCodeGoogleUrl('Myshop', $checkTag);
  $oneCode = $ga->getCode($checkTag);




  if (isPost()) {
    $otp = filter_input(INPUT_POST, 'otp2');
    $checkResult = $ga->verifyCode($checkTag, $otp, 2);
    if (false === (bool)$otp) {
      $errors[] = "OTP is empty";
    }

    if ((bool)$otp && false === $checkResult) {
      $errors[] = "OTP is wrong";
    }
    $userData = getUserDataForId($userId);
    if (0 === count($errors)) {
      if ($checkResult) {
          $_SESSION['userId']=$userId;

        userLogin($userId,$os,$resolution);
        

        $redirectTarget = $baseUrl . 'index.php';
        if (isset($_SESSION['redirectTarget'])) {
          $redirectTarget = $_SESSION['redirectTarget'];
        }
        flashMessage("Welcome $userData[firstname], you logged in last time on $userData[lastLogin]");
        
        header("Location: " . $baseUrl . "index.php");
      }
    }
  }
  $hasErrors = count($errors) > 0;
  require __DIR__ . '/templates/verify.php';
  exit();
}

if (strpos($route, '/Datenschutz') !== false) {
  require __DIR__ . '/templates/dataProtect.php';
}

