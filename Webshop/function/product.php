<?php

function getAllProducts(){
    $sql ="SELECT id,titel,beschreibung,preis,pics,slug FROM Products;";

    $result= getDB() -> query($sql);
    if(!$result){
        return [];
    }
    $products = [] ;
    while($row=$result->fetch()){
        $products[]=$row;
    }
    return $products;
}

function getProductsBySlug(string $slug):?array{
    $sql ="SELECT id,titel,beschreibung,preis,pics,slug FROM Products
    WHERE slug=:slug
    LIMIT 1 ";
    $statement = getDB()->prepare($sql);
    if(false === $statement){
        return null;
    }
    $statement->execute(
        [':slug'=>$slug]
    );
    if($statement->rowCount() ===0){
        return null;
    }
    return $statement->fetch();
}