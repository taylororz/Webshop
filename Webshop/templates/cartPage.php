<?php require_once __DIR__.'/header.php'?>
<section class="container" id="cartItems">
    <div class="row">
     <h2>Warenkorb</h2>
    </div>
    <div class="row cartItemHeader">
    <div class="row">
        <div class="col-8 text-end">Quantity</div>
        <div class="col-4 text-end">Preis</div>
    </div>
	</div>
    <?php foreach( $cartItems as $cartItem):?>
    <div class="row cartItem">
        <?php include __DIR__.'/cartItem.php';?>
    </div>
    <?php endforeach;?>
    <div class="row">
        <div class="col-12 text-end">
        Summe (<?= $countCartItems ?> Artikel): <span class="preis"><?=number_format($cartSum/1,2,","," ")?> &#8364</span>
        </div>
    </div>
    <div class="row">
        <a href="index.php/checkout" class="btn btn-primary col-12">Kasse</a>
    </div>
    <?php require_once __DIR__.'/footer.php'?>