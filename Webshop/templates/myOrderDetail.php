<?php require_once __DIR__.'/header.php'?>

<section class="container-fluid" id="myOrder">
    
     <h2 style="text-align: center;">My Order:<?=$orderId?></h2>
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
    <a href="./index.php/myOrder" class="btn btn-success" style="position:center"> Back</a>
  </div>
  </div>
  </div>
<?php require_once __DIR__.'/footer.php'?>
