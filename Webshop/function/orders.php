<?php 
function createOrder(int $userId,array $cartItems, string $status='new'):bool{
    $sql="INSERT INTO orders SET 
            status = :status,
            usedId = :userId";
    
    $statement = getDB()-> prepare($sql);
    $data = [
        ':status' => $status,
        ':usedId' => $userId
    ];

    $statement->execute($data);
    $orderId= getDB()->lastInsertId();

    $sql="INSERT INTO order_products SET
            title = :title,
            quantity = :quantity,
            price = :price,
            taxinPercent = :taxPercent,
            orderId = :orderId ";
    
    $statement = getDB()-> prepare($sql);
    foreach($cartItems as $cartItem){
        $taxinPercent=19;
        $price = $cartItem['price'];
        $netPrice =(100-($taxinPercent/100))*$price;

        $data = [
        ':title' => $cartItem['title'],
        ':quantity' => $cartItem['quantity'],
        ':price' => $netPrice,
        ':taxinPercent' => 19,
        ':useId' => $userId
        ];

        $statement -> execute($data);
    }
    
    return true;

}