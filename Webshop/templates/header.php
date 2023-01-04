<!DOCTYPE html>
<html lang="de">
<head>
    <title>Webshop</title>
    <meta charset="utf-8">
    <base href="<?=$baseUrl ?>">
    <?php if(false===$isEmail):?>
    <link rel="stylesheet" href="./assets/styles.css">
    <?php endif;?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
<?php if(false===$isEmail):?>
<?php include __DIR__.'/navbar.php'?>
<?php endif;?>
<header class="p-4 mb-4 bg-light rounded-3">
    <div class="container">
        <h2>Your online eBike shop</h2>
    </div>
</header>