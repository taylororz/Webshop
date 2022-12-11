<?php

function saveAddressForUser(int $userId,string $firstname,string $lastname,string $address1, string $address2, string $country,string $states,string $zipCode):int{
    $sql="INSERT INTO address
          SET user_id=:userId,
              firstname=:firstname,
              lastname=:lastname,
              address1=:address1,
              address2=:address2,
              country=:country,
              states=:states,
              zipCode=:zipCode";
    
    $statement=getDB()->prepare($sql);
    if(false === $statement){
        return 0;
    }

    $statement->execute([
        ':userId'=>$userId,
        ':firstname'=>$firstname,
        ':lastname'=>$lastname,
        ':address1'=>$address1,
        ':address2'=>$address2,
        ':country'=>$country,
        ':states'=>$states,
        ':zipCode'=>$zipCode
    ]);
    return (int)getDB()->lastInsertId();
}

function getAddressForUser(int $userId):array{
    $sql = "SELECT id,firstname,lastname,address1,address2,country,states,zipCode
            FROM address WHERE user_id=:userId ";

    $statement = getDB()->prepare($sql);
    if(false===$statement){
        return [];
    }
    
    $addresses=[];

    $statement->execute([
        ':userId'=>$userId
    ]);

    while($row = $statement->fetch()){
        $addresses[]=$row;
    }
    return $addresses;
}

function addressBelongsToUser(int $deliveryAddressId,int $userId):bool{
    $sql="SELECT id
          FROM address WHERE user_id =:userId AND id = :deliveryAddressId";
    
    $statement=getDB()->prepare($sql);
    if(false === $statement){
        return false;
    }

    $statement->execute([
        ':userId'=>$userId,
        ':deliveryAddressId'=>$deliveryAddressId
    ]);

    return (bool)$statement->rowCount();
}