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
<section class="row" id="companyLogo">
</section>
<section class="row" id="companyDetails">
  <div>
    <?= COMPANY_NAME ?> | <?= COMPANY_STREET ?> | <?= COMPANY_ZIP ?> <?= COMPANY_CITY?>
  </div>
</section>
<section class="row" id="invoiceAddress">
  <div>
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
  <div class="col-2 offset-4">
  <strong>Customer Number:</strong>
  <p><?= $userData['customerNr']?></p>
  </div>
  <div class="col-2">
  <strong>Date of Invoice:</strong>
  <p><?= $orderData['orderDateFormat']?></p>
  </div>
</section>
<section class="row" id="invoiceHeader">
  <h1 class="col-12">Invoice Nr. <?=$orderData['id']?></h1>
</section><section class="row" id="invoiceSentence">
  <p>Thank you for your order.</p>
</section>
    <section id="product">
        <?php foreach($orderData['products'] as $order): ?>
          <div>
            <?=$order['title']?>
            <?=$order['quantity']?>
            <?=$order['price']?>
            <?=$order['taxinPercent']?>
          </div>
        <?php endforeach ?>
    </section>
    <section class="row" id="sum">
</section>
<section class="row" id="invoiceDetailsFooter">
</section>
<section class="row" id="footer">
</section>
</div>
</body>
