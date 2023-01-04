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
<div class="pdf-container">
  <div class="container-fluid">
<section class="row" id="companyLogo">
</section>
<section class="row" id="companyDetails">
  <div class="col-12">
   <?= COMPANY_NAME ?> | <?= COMPANY_STREET ?> | <?= COMPANY_ZIP ?> <?= COMPANY_CITY?>
  </div>
</section>
<section class="row" id="invoiceAddress">
  <div class="col-12">
    <?= $orderData['deliveryAddressFields']['firstname']?>
    <?= $orderData['deliveryAddressFields']['lastname']?>
    <?= $orderData['deliveryAddressFields']['address1']?>
    <?= $orderData['deliveryAddressFields']['address2']?>
    <?= $orderData['deliveryAddressFields']['zipCode']?>
    <?= $orderData['deliveryAddressFields']['city']?>
    <?= $orderData['deliveryAddressFields']['country']?>

  </div>
</section>
<section class="row" id="invoiceDetails">
  <div class="col-3 offset-4">
  <strong>Customer Number:</strong>
  <p><?= $userData['customerNr']?></p>
  </div>
  <div class="col-3">
  <strong>Date of Invoice:</strong>
  <p><?= $orderData['orderDateFormat']?></p>
  </div>
</section>
<section class="row" id="invoiceHeader">
  <h1 class="col-12">Invoice Nr. <?=$orderData['id']?></h1>
</section>
<section class="row" id="invoiceSentence">
  <p>Thank you for your order.</p>
</section>
    <section id="product">
      <table class="table">
     <thead>
       <tr>
         <th>
           Pos.
         </th>
         <th>
           Title
         </th>
         <th>
           Quantity
         </th>
         <th>
           Price (€)
         </th>
         <th>
           Total (€)
         </th>
       </tr>
        </thead>
        <tbody>
        <?php foreach($orderData['products'] as $index=> $order): ?>
          <tr>
            <td><?= ++$index?></td>
           <td> <?=$order['title']?> </td>
            <td><?=$order['quantity']?> </td>
            <td><?=number_format ($order['price'],2,"," , " ")?></td>
           <td><?=number_format ($order['price']* $order['quantity'],2,"," , " ")?></td>
          </tr>
        <?php endforeach ?>
        </tbody>
        <tfoot>
          <tr>
       <td colspan="4" id="text">Subtotal:</td>
       <td><?=number_format ($orderSum['sumNet'],2,"," , " ")?>€</td>
     </tr>
     <tr>
       <td colspan="4" id="text">Tax Rate 19%:</td>
       <td><?=number_format ($orderSum['taxes'],2,"," , " ")?>€</td>
     </tr>
     <tr class="total">
       <td colspan="4" id="text">Balance:</td>
       <td><?=number_format ($orderSum['sumBrut'],2,"," , " ")?>€</td>
      </tfoot>
        </table>
        </section>
        <section class="row" id="invoiceDetailsFooter">
   <p class="col-12">Payment within 14 days of receipt of the invoice without any deductions to the bank details given below.</p>
 </section>
  </div>
</div>
<?php require_once __DIR__.'/footer.php'?>
