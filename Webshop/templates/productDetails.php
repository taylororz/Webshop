<?php require_once __DIR__.'/header.php'?>
<section class="container-fluid" id="productDetails">
    <div class="card">
    <div class="card-header">
    <h2><?=$product['titel']?></h2>
    </div>
    <div class="card-body">
    <div class="row">
        <div class="col-6">
        <img src="<?= $product['pics']?>" class="productPicture" alt="products" width=480px height=280px>
        </div>
        <div class="col-6">
        <div >Price: <b><?=number_format ($product['preis'],2,"," , " ") ?> &#8364</div>
        <hr/>
        <div><?= $product['beschreibung'] ?></div>
        </div> 
    </div>
    </div>
    <div class="card-footer">
    <a href="index.php" class="btn btn-primary btn-sm">Back to homepage</a>
   
    <a href="index.php/cart/add/<?= $product['id']?>" class="btn btn-success btn-sm">Add Cart</a>
    </div>
</div>
    </div>
</section>
<?php require_once __DIR__.'/footer.php'?>