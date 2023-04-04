<?php require_once __DIR__.'/header.php'?>

<section class="container" id="products">
    <?php if($hasFlashMessage):?>
  <div class="alert alert-success" role="alert">
    <?php foreach($flashMessage as $message):?>
        <p><?= $message?></p>
    <?php endforeach;?>
  </div>
  <?php endif ?>
</section>

<div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item" data-bs-interval="5000">
        <div class="d-flex justify-content-center">
          <img class="d-block w-70 " width="800px" height="400px" src="./Pics/bike-5160600_1280.jpg" role="img" >
     </div>
        </div>
        <div class="carousel-item" data-bs-interval="5000">
        <div class="d-flex justify-content-center">
          <img class="d-block w-70 " width="800px" height="400px" src="./Pics/mountain-biking-95032_1280.jpg" role="img">
          </div>
        </div>
        <div class="carousel-item active">
        <div class="d-flex justify-content-center">
          <img class="d-block w-70 " width="800px" height="400px" src="./Pics/bike-2934832_1280.jpg" role="img" >
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <hr>
    <div class="container">
    <div class="row gy-3">
        <?php foreach($products as $product):?>
        <div class="col-md-4 mb-4">
            <?php include 'card.php'?>
        </div>
        <?php endforeach; ?>
    </div>    
    </div>
<?php require_once __DIR__.'/footer.php'?>