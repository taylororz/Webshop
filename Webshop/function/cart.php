<?php
 function addProductToCart(int $userId, int $productId, int $quantity = 1){
    $sql="INSERT INTO `shopping cart` 
    SET quantity = :quantity, user_id = :userId, product_id = :productId
    ON DUPLICATE KEY UPDATE quantity = quantity +:quantity
    ";
    $statement = getDB()->prepare($sql);
    
    $statement -> execute([
        ':userId'=> $userId,
        ':productId'=> $productId,
        ':quantity'=> $quantity
    ]);
 }

 function countProductsInCart(int $userId){
    $sql ="SELECT COUNT(id) FROM `shopping cart` WHERE user_id =".$userId;
    $cartResults = getDB()->query($sql);
    $cartItems =$cartResults->fetchColumn();
    return $cartItems;
 }

 function getCartItemsForUserId(int $userId){
   $sql="SELECT product_id, titel, beschreibung, preis, pics, quantity
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

function getCartSumForUserId(int $userId){
   $sql="SELECT SUM(preis*quantity)
         FROM `shopping cart`
         JOIN products ON(`shopping cart`.product_id = products.id)
         WHERE user_id = ".$userId;
   $result = getDB()->query($sql);
   if($result===false){
      return 0;
   }
   return $result->fetchColumn();
}

function deleteProductInCartForUserId(int $userId,int $productId):int{
   $sql="DELETE FROM `shopping cart`
         WHERE user_id=:userId
         AND product_id =:productId";
   $statement = getDB()->prepare($sql);
   if(false === $statement){
      return 0;
   }

   return $statement->execute([
      ':userId'=>$userId,
      ':productId'=>$productId
   ]
   );
}

function moveCartProductsToAnotherUser(int $sourceUserId,int $targetUserId):int{

   $oldCartItems= getCartItemsForUserId($sourceUserId);
   if(count($oldCartItems)===0){
      return 0;
   }
      $moveProducts =0;

      foreach($oldCartItems as $oldCartItems){
         addProductToCart($targetUserId,(int)$oldCartItems['product_id'],(int)$oldCartItems['quantity']);
         $moveProducts += deleteProductInCartForUserId($sourceUserId,$oldCartItems['product_id']);
      }
      return $moveProducts;
   }

