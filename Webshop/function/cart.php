<?php
 function addProductToCart(int $userId, int $productId){
    $sql="INSERT INTO `shopping cart` SET user_id = :userId,product_id=:productId";
    $statement = getDB()->prepare($sql);
    $statement -> execute([
        ':userId'=> $userId,
        ':productId'=> $productId
    ]);
 }

 function countProductsInCart(int $userId){
    $sql ="SELECT COUNT(id) FROM `shopping cart` WHERE user_id =".$userId;
    $cartResults = getDB()->query($sql);
    $cartItems =$cartResults->fetchColumn();
    return $cartItems;
 }

 function getCartItemsForUserId(int $userId){
   $sql="SELECT product_id, titel, beschreibung, preis, pics
         FROM `shopping cart`
         JOIN products ON(`shopping cart`.product_id = products.id)
         WHERE user_id = ".$userId;
   $results = getDB()->query($sql);
   if($results===false){
      return[];
   }
   $found = [];
   while($row = $results->fetch()){
      $found[]=$row;
   }
   return $found;
 }

function getCartSumForUserId(int $userId):int{
   $sql="SELECT SUM(preis)
         FROM `shopping cart`
         JOIN products ON(`shopping cart`.product_id = products.id)
         WHERE user_id = ".$userId;
   $result = getDB()->query($sql);
   if($result===false){
      return 0;
   }
   return (int)$result->fetchColumn();
}