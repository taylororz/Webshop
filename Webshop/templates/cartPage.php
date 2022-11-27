<!DOCTYPE html>
<html lang="de">
<head>
    <title>Webshop</title>
    <meta charset="utf-8">
    <base href="<?=$baseUrl ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/styles.css">
</head>
<body>
<?php include __DIR__.'/navbar.php'?>
<header class="p-5 mb-4 bg-light rounded-3">
    <div class="container">
        <h1>Willkommen auf meinem Online Shop</h1>
    </div>
</header>
<section class="container" id="cartItems">
    <div class="row">
     <h2>Warenkorb</h2>
    </div>
    <div class="row cartItemHeader">
		<div class="col-12 text-end">
			Preis
		</div>
	</div>
    <?php foreach( $cartItems as $cartItem):?>
    <div class="row cartItem">
        <?php include __DIR__.'/cartItem.php';?>
    </div>
    <?php endforeach;?>
    <div class="row">
        <div class="col-12 text-end">
        Summe (<?= $countCartItems ?> Artikel): <span class="preis"><?=$cartSum ?> &#8364</span>
        </div>
    </div>
    <div class="row">
        <a href="#" class="btn btn-primary col-12">Kasse</a>
    </div>
</section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>