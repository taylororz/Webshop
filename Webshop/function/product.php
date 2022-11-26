<?php

function getAllProducts(){
    $sql ="SELECT id,titel,beschreibung,preis,pics FROM Products;";

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