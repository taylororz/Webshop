<div class="card">
    <div class="card-titel">
        <?= $product['titel']?>
    </div>
    <img src="<?= $product['pics']?>" class="card-img-top" alt="products"/>
    <div class="card-body">
        <?=$product['beschreibung'] ?>
        <hr>
        <?=$product['preis']?>,00 &#8364
    </div>
    <div class="card-footer">
        <a href="" class="btn btn-primary btn-sm">details</a>
        <a href="index.php/cart/add/<?= $product['id']?>" class="btn btn-success btn-sm">In den Warenkorb</a>
    </div>
</div>