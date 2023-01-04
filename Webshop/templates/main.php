<?php require_once __DIR__.'/header.php'?>

<section class="container" id="products">
    <?php if($hasFlashMessage):?>
  <div class="alert alert-success" role="alert">
    <?php foreach($flashMessage as $message):?>
        <p><?= $message?></p>
    <?php endforeach;?>
  </div>
  <?php endif ?>
    <div class="row">
        <?php foreach($products as $product):?>
        <div class="col">
            <?php include 'card.php'?>
        </div>
        <?php endforeach; ?>
    </div>
    
<?php require_once __DIR__.'/footer.php'?>