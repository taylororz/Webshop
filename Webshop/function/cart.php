<?php
 function addProductToCart(int $userId, int $productId, int $quantity){
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

 function countProductsInCart(?int $userId){
   if(null === $userId){
      return 0;
   }
    $sql ="SELECT SUM(quantity) FROM `shopping cart` WHERE user_id =".$userId;
    $cartResults = getDB()->query($sql);
    $cartItems =$cartResults->fetchColumn();
    return $cartItems;
 }

 function getCartItemsForUserId(?int $userId):array{
   if(null === $userId){
      return [];
   }
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

function getCartSumForUserId(?int $userId){
   if(null === $userId){
      return 0;
   }
   $sql="WITH Total AS
         (SELECT titel, preis, quantity, 
         IF(quantity>=10,(preis*quantity*0.8),
         IF(quantity>=5,(preis*quantity*0.9),(preis*quantity))) 
         as total FROM `shopping cart` JOIN products ON(`shopping cart`.product_id = products.id)
         WHERE user_id = :userId) SELECT SUM(total) FROM Total;";

   $result = getDB()->prepare($sql);
   if($result===false){
      return 0;
   }
   $result->execute([
      ':userId'=>$userId
   ]);
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

   function clearCartForUser(int $userId){
      $sql = "DELETE FROM `shopping cart` where user_Id = :user_Id";
      $statement = getDB()->prepare($sql);
      $statement ->execute([':user_Id'=>$userId]);
   }

   function getOriginalCartSumForUserId(?int $userId){
      if(null === $userId){
         return 0;
      }
      $sql="SELECT SUM(preis*quantity) AS total FROM `shopping cart` 
      JOIN products ON(`shopping cart`.product_id = products.id) 
      WHERE user_id = :userId";
   
      $result = getDB()->prepare($sql);
      if($result===false){
         return 0;
      }
      $result->execute([
         ':userId'=>$userId
      ]);
      return $result->fetchColumn();
   }

   function changeCart($userId,$productId,$quantity){
      $sql="UPDATE `shopping cart`
            SET quantity=:quantity
            WHERE user_id=:userId
         AND product_id =:productId";
      $statement = getDB()->prepare($sql);
      if(false === $statement){
         return 0;
      }
   
      return $statement->execute([
         ':quantity'=>$quantity,
         ':userId'=>$userId,
         ':productId'=>$productId
      ]
      );
   }