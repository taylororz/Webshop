<?php 
function createOrder(int $userId,array $cartItems,string $firstname,string $lastname,string $address1,string $address2,string $country,string $city,int $zipCode,int $deliveryId):bool{

    $sql ="INSERT INTO orders SET  
            status = 'new',
            userId = :userId";
    
    $statement = getDB()-> prepare($sql);
    if(false === $statement){
        echo printDBErrorMessage();
        return false;
    }
    $data = [
        ':userId' => $userId
    ];

    $created=$statement->execute($data);
    if(false === $created){
        echo printDBErrorMessage();
        return false;
    }
    $orderId= getDB()->lastInsertId();

    $sql = "INSERT INTO order_address SET
     order_id= :orderId,
     firstname=:firstname,
     lastname=:lastname,
     address1=:address1,
     address2=:address2,
     country=:country,
     city=:city,
     zipCode=:zipCode";

     $statement = getDB()->prepare($sql);
     if(false === $statement){
        echo printDBErrorMessage();
        return false;
    }
     $data = [
        ':orderId'=>$orderId,
        ':firstname'=>$firstname,
        ':lastname'=>$lastname,
        ':address1'=>$address1,
        ':address2'=>$address2,
        ':country'=>$country,
        ':city'=>$city,
        ':zipCode'=>$zipCode
     ];     

     $created=$statement->execute($data);
    if(false === $created){
        echo printDBErrorMessage();
        return false;
    }
    

    $sql="INSERT INTO orders_products SET
            title = :title,
            quantity = :quantity,
            price = :price,
            taxinPercent = :taxinPercent,
            orderId = :orderId,
            deliveryId	=:deliveryId";
    
    $statement = getDB()-> prepare($sql);
     if(false === $statement){
        echo printDBErrorMessage();
        return false;
    }

    foreach($cartItems as $cartItem){
        $taxinPercent = 19;
        $price = $cartItem['preis'];
        $netPrice = $price/(1+($taxinPercent/100));

        $data = [
        ':title' => $cartItem['titel'],
        ':quantity' => $cartItem['quantity'],
        ':price' => $netPrice,
        ':taxinPercent' => 19,
        ':orderId' => $orderId,
        ':deliveryId'=>$deliveryId
        ];

        $created=$statement->execute($data);
    if(false === $created){
        echo printDBErrorMessage();
        break;
    }
    }
    
    return true;
}

function getOrderForUserwithoutDate(int $orderId,int $userId):?array{
    $sql="SELECT userId, id, status
        FROM orders
        WHERE Id = :orderId AND userId=:userId
        LIMIT 1 ";

    $statement = getDB()->prepare($sql);
    if(false === $statement){
        echo printDBErrorMessage();
        return null;
    }

    $statement -> execute([
        ':orderId' => $orderId,
        ':userId' => $userId 
    ]);

    if(0 === $statement->rowCount()){
        return null;
    }

    $orderData = $statement->fetch();
    $orderData ['products'] = [];
    $orderData ['deliveryAddressFields']=[];
    $sql="SELECT 
    firstname,lastname,
    address1,address2,
    country,city,zipCode,`typ`
    FROM order_address
    WHERE order_id = :orderId LIMIT 1";

    $statement = getDB()->prepare($sql);
    if(false === $statement){
        echo printDBErrorMessage();
    return null;
    }

    $statement->execute([':orderId'=>$orderId]);
    if(0 === $statement->rowCount()){
        printDBErrorMessage();
        return null;
    }

    $orderData['deliveryAddressFields']=$statement->fetch();

    $sql = "SELECT id, title, quantity, price, taxinPercent,deliveryId
            FROM orders_products
            WHERE orderId = :orderId";

    $statement = getDB()->prepare($sql);
    if(false === $statement){
        echo printDBErrorMessage();
    return null;
}

    $statement -> execute([
        ':orderId' => $orderId
    ]);

    if(0 === $statement->rowCount()){
        return null;
    }

    while($row=$statement ->fetch()){
        $orderData['products'][]=$row;
    }
    return $orderData;
}





function getSingleOrderForUser(int $orderId,int $userId):?array{
    $sql="SELECT orderDate, userId, id, status
        FROM orders
        WHERE Id = :orderId AND userId=:userId
        LIMIT 1 ";

    $statement = getDB()->prepare($sql);
    if(false === $statement){
        echo printDBErrorMessage();
        return null;
    }

    $statement -> execute([
        ':orderId' => $orderId,
        ':userId' => $userId 
    ]);

    if(0 === $statement->rowCount()){
        return null;
    }

    $orderData = $statement->fetch();
    $date=date_create($orderData['orderDate']);
    $orderData ['orderDateFormat'] = date_format($date,'d.m.Y');
    $orderData ['products'] = [];
    $orderData ['deliveryAddressFields']=[];
    $sql="SELECT 
    firstname,lastname,
    address1,address2,
    country,city,zipCode,`typ`
    FROM order_address
    WHERE order_id = :orderId LIMIT 1";

    $statement = getDB()->prepare($sql);
    if(false === $statement){
        echo printDBErrorMessage();
    return null;
    }

    $statement->execute([':orderId'=>$orderId]);
    if(0 === $statement->rowCount()){
        printDBErrorMessage();
        return null;
    }

    $orderData['deliveryAddressFields']=$statement->fetch();

    $sql = "SELECT id, title, quantity, price, taxinPercent,deliveryId
            FROM orders_products
            WHERE orderId = :orderId";

    $statement = getDB()->prepare($sql);
    if(false === $statement){
        echo printDBErrorMessage();
    return null;
}

    $statement -> execute([
        ':orderId' => $orderId
    ]);

    if(0 === $statement->rowCount()){
        return null;
    }

    while($row=$statement ->fetch()){
        $orderData['products'][]=$row;
    }
    return $orderData;
}

function getOrderSumForUser(int $orderId,int $userId):?array{
    $sql="SELECT SUM(price*quantity) AS sumNet,
    CONVERT(SUM(price*quantity)*(1+taxInPercent/100), double) AS sumBrut,
    CONVERT((SUM(price*quantity)*(1+taxInPercent/100)) - ( SUM(price*quantity) ),double) AS taxes
    FROM orders_products op
    INNER JOIN orders o ON(op.orderId = o.id)
    WHERE userId = :userId
    AND orderId = :orderId";
 
    $statement = getDB()->prepare($sql);
    if(false === $statement){
      echo printDBErrorMessage();
      return null;
    }
    $statement->execute([
      ':orderId'=>$orderId,
      ':userId'=>$userId
    ]);
    if(0 === $statement->rowCount()){
      return null;
    }
    return $statement->fetch();
  }

  function getOrderNrforUser(int $userId){
            $sql="SELECT orderDate,id FROM orders WHERE userId='".$userId."'";

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

        function getOrderDetail(int $orderId):?array{
            $sql="SELECT id,title,quantity,+
            CONVERT((price*quantity), double) 
            AS price FROM orders_products WHERE orderId=:orderId";

            $statement = getDB()->prepare($sql);
            if(false === $statement){
            echo printDBErrorMessage();
            return null;
            }
            $statement->execute([
            ':orderId'=>$orderId,
            ]);
            if(0 === $statement->rowCount()){
            return null;
            }
            while($row=$statement ->fetch()){
                $orderData['products'][]=$row;
            }
            return $orderData;
        }
  
    function getDeliverymethod(int $orderId){
        $sql="SELECT method,cost FROM delivery,orders_products 
            WHERE delivery.id=orders_products.deliveryId AND orders_products.orderId=:orderId
            LIMIT 1;";

        $statement = getDB()->prepare($sql);
        if(false === $statement){
        echo printDBErrorMessage();
        return null;
        }
        $statement->execute([
        ':orderId'=>$orderId
        ]);
        if(0 === $statement->rowCount()){
        return null;
        }
        return $statement->fetch();
}


function orderAgain(int $userId,array $getData):bool{

    $sql ="INSERT INTO orders SET  
            status = 'new',
            userId = :userId";
    
    $statement = getDB()-> prepare($sql);
    if(false === $statement){
        echo printDBErrorMessage();
        return false;
    }
    $data = [
        ':userId' => $userId
    ];

    $created=$statement->execute($data);
    if(false === $created){
        echo printDBErrorMessage();
        return false;
    }
    $orderId= getDB()->lastInsertId();

    $getAddressFromUser=$getData['deliveryAddressFields'];


    $sql = "INSERT INTO order_address SET
     order_id= :orderId,
     firstname=:firstname,
     lastname=:lastname,
     address1=:address1,
     address2=:address2,
     country=:country,
     city=:city,
     zipCode=:zipCode";

     $statement = getDB()->prepare($sql);
     if(false === $statement){
        echo printDBErrorMessage();
        return false;
    }
     $data = [
        ':orderId'=>$orderId,
        ':firstname'=>$getAddressFromUser['firstname'],
        ':lastname'=>$getAddressFromUser['lastname'],
        ':address1'=>$getAddressFromUser['address1'],
        ':address2'=>$getAddressFromUser['address2'],
        ':country'=>$getAddressFromUser['country'],
        ':city'=>$getAddressFromUser['city'],
        ':zipCode'=>$getAddressFromUser['zipCode']
     ];     

     $created=$statement->execute($data);
    if(false === $created){
        echo printDBErrorMessage();
        return false;
    }
    
    $getProduct=$getData['products'];

    $sql="INSERT INTO orders_products SET
            title = :title,
            quantity = :quantity,
            price = :price,
            taxinPercent = :taxinPercent,
            orderId = :orderId,
            deliveryId	=:deliveryId";
    
    $statement = getDB()-> prepare($sql);
     if(false === $statement){
        echo printDBErrorMessage();
        return false;
    }

    foreach($getProduct as $getProduct){

        $data = [
        ':title' => $getProduct['title'],
        ':quantity' => $getProduct['quantity'],
        ':price' => $getProduct['price'],
        ':taxinPercent' => 19,
        ':orderId' => $orderId,
        ':deliveryId'=>$getProduct['deliveryId']
        ];

        $created=$statement->execute($data);
    if(false === $created){
        echo printDBErrorMessage();
        break;
    }
    }
    
    return $created;

}

function getOrderId($userId){
    $sql ="SELECT MAX(id) FROM orders WHERE userId='.$userId.';";
    $statement=getDB()->query($sql);
    return $statement->fetchColumn();
    }

function getSumForOrder($orderId,$userId){
    $sql="SELECT SUM(
    IF(o.quantity>=10,(o.price*o.quantity*0.8),
    IF(o.quantity>=5,(o.price*o.quantity*0.9),(o.price*o.quantity))))AS total
    FROM orders , orders_products o 
    WHERE o.orderId=".$orderId." and o.orderId=orders.id and orders.userId =".$userId.";";

    $statement=getDB()->query($sql);
    return $statement->fetchColumn();
}


