<?php require_once __DIR__.'/header.php'?>
<section class="container-fluid" id="cartItems">
    
     <h2>Shopping Cart</h2>
     <div class="container-fluid col-11" >
     <table class="table">
    <thead>
    <tr>
    <th scope="col"></th>
      <th scope="col"></th>
      <th scope="col">Title</th>
      <th scope="col">Action</th>
      <th scope="col" style="text-align: center;">Quantity</th>
      <th scope="col"  style="text-align: center;">Price</th>
    </tr>
  </thead>
  <tbody>
  <tr>
    <?php foreach( $cartItems as $cartItem):?>
        <?php include __DIR__.'/cartItem.php';?>
        </tr>

    <?php endforeach;?>

    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td style="text-align: right;">Subtotal (<?= $countCartItems ?> Items):</td>
      <td style="text-align: center;"> <span class="preis"><?=number_format($cartOrignalSum/1,2,","," ")?> &#8364</span></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td style="text-align: right;">Discount:</td>
      <td style="text-align: center;"> <span class="preis"><?=number_format(($cartSum-$cartOrignalSum)/1,2,","," ")?> &#8364</span></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td style="text-align: right;">Total (<?= $countCartItems ?> Items):</td>
      <td style="text-align: center;"> <span class="preis"><?=number_format($cartSum/1,2,","," ")?> &#8364</span></td>
    </tr>
    </tbody>
</table>
        <a href="index.php/checkout" class="btn btn-primary col-12">Kasse</a>
    </div>

    <?php require_once __DIR__.'/footer.php'?>

