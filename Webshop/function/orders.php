<?php 
function createOrder(int $userId,array $cartItems,array $deliveryAddressFields,string $status = 'new'):bool{

    $sql ="INSERT INTO orders SET  
            status = :status,
            userId = :userId";
    
    $statement = getDB()-> prepare($sql);
    if(false === $statement){
        echo printDBErrorMessage();
        return false;
    }
    $data = [
        ':status' => $status,
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
        ':firstname'=>$deliveryAddressFields['firstname'],
        ':lastname'=>$deliveryAddressFields['lastname'],
        ':address1'=>$deliveryAddressFields['address1'],
        ':address2'=>$deliveryAddressFields['address2'],
        ':country'=>$deliveryAddressFields['country'],
        ':city'=>$deliveryAddressFields['city'],
        ':zipCode'=>$deliveryAddressFields['zipCode'],
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
            orderId = :orderId";
    
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
        ':orderId' => $orderId
        ];

        $created=$statement->execute($data);
    if(false === $created){
        echo printDBErrorMessage();
        break;
    }
    }
    
    return $created;

}

function getOrderForUser(int $orderId,int $userId):?array{
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

    $sql = "SELECT id, title, quantity, price, taxinPercent
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