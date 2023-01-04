<div class="card">
    <div class="card-titel">
        <?= $product['titel']?>
    </div>
    <img src="<?= $product['pics']?>" class="card-img-top" alt="products" width="634px" height="370px"/>
    <div class="card-body">
        <?=$product['beschreibung'] ?>
        <hr>
        <?=number_format($product['preis'],2,"," , " ") ?> &#8364
    </div>
    <div class="card-footer">
        <a href="index.php/product/<?= $product['slug']?>" class="btn btn-primary btn-sm">Details</a>
        <a href="index.php/cart/add/<?= $product['id']?>" class="btn btn-success btn-sm">Add cart</a>
    </div>
</div>