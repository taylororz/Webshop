
<div class="card h-100">
    <div class="card-titel">
        <?= $product['titel']?>
    </div>
    <div class="container-fluid">
    <img src="<?= $product['pics']?>" class="card-img-top img-fluid" alt="products" >
    </div>
    <div class="card-body">
        <hr>
        <?=number_format($product['preis'],2,"," , " ") ?> &#8364
    </div>
    <form action="index.php/cart/add/<?=$product['id']?>" method="POST">
    <div class="card-footer">
        <a href="index.php/product/<?= $product['slug']?>" class="btn btn-primary btn-sm">Details</a>
        <input type="number" id="addcart" value="1" min="1" name="quantity" id="quantity" style="width:48px;">
        <button type="submit" class="btn btn-success btn-sm">Add cart</button>
    </div>
    </form>
</div>