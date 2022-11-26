<!DOCTYPE html>
<html lang="de">
<head>
    <title>Webshop</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link type="text/css" href="styles.css">
</head>
<body>
<?php include __DIR__.'/navbar.php'?>
<header class="p-5 mb-4 bg-light rounded-3">
    <div class="container">
        <h1>Willkommen auf meinem Online Shop</h1>
    </div>
</header>
<section class="container" id="products">
    <div class="row">
        <?php foreach($products as $product):?>
        <div class="col">
            <?php include 'card.php'?>
        </div>
        <?php endforeach; ?>
    </div>
    
</section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>