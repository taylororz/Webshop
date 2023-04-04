
<?php require_once __DIR__.'/header.php'?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<section id="activationMail" class="container">

<div class="card">
  <div class="card-header">
    <div class="row">
    <div class="col-12">
      <h1>Myshop<h1>
    </div>
    <div class="offset-6 col-6 text-end">
    <div id="users"><strong> OrderNr.<?= $getNewOrderId ?> </strong></div>
    </div>
    </div>
 </div>
  <div class="card-body" id="content">
    <p>Hi <?= $getAddressFromUser['firstname'] ?> <?= $getAddressFromUser['lastname'] ?>,</p>
    <p>Thank you for your order.<br />
    Here are your order overview:</p>

    <section class="container-fluid" id="myOrder">
    
     <h2 style="text-align: center;">My Order:<?=$getNewOrderId?></h2>
     <div class="container-fluid col-11" >
     <div class="card" style="text-align: center;">

     <table class="table" >
    <thead>
    <tr>
      <th scope="col">Nr.</th>
      <th scope="col">Title</th>
      <th scope="col">Quantity</th>
      <th scope="col">Price</th>
         <strong>Delivery method:<?=$deliveryMethod['method']?></strong>
    </tr>
  </thead>
  <tbody>
  <?php foreach($orderData['products'] as $index=> $order): ?>
    <tr>
      <td><?=++$index?></td>
      <td><?=$order['title']?></td>
      <td><?=$order['quantity']?></td>
      <td><?=number_format ($order['price'],2,"," , " ")?> &#8364</td>
    </tr>
    <?php endforeach;?>
    <tr>
      
    
      <td></td>
      <td></td>
      <td style="text-align: right;">Discount:</td>
      <td style="text-align: center;"> <span class="preis"><?=number_format(($getSum-$getSumNetto['sumNet'])/1,2,","," ")?> &#8364</span></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td style="text-align: right;">Subtotal:</td>
      <td style="text-align: center;"> <span class="preis"><?=number_format($getSum/1,2,","," ")?> &#8364</span></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td style="text-align: right;">Delivery cost(inclu.Taxes):</td>
      <td style="text-align: center;"> <span class="preis"><?=number_format($deliveryMethod['cost']/1,2,","," ")?> &#8364</span></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td style="text-align: right;">Taxes(19%):</td>
      <td style="text-align: center;"> <span class="preis"><?=number_format(($getSum*0.19)/1,2,","," ")?> &#8364</span></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td style="text-align: right;">Total :</td>
      <td style="text-align: center;"> <span class="preis"><?=number_format(($getSum*1.19+$deliveryMethod['cost'])/1,2,","," ")?> &#8364</span></td>
    </tr>
    </tbody>
</table>
  </section>
  <div class="col-md-12 text-center">
  </div>
  

    <p>Thank you for choosing our store!</p>
    <p>Best regards</p>
    <p>Myshop - Team</p>
    </div>
    </div>
  </div>
<?php require_once __DIR__.'/footer.php'?>