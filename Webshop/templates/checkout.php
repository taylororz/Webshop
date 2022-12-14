<?php require_once __DIR__.'/header.php'?>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
      
    </style>
    
  </head>
  <body>
    
<div class="container">
  <main>
    <div class="py-5 text-center">
      <h2>Checkout</h2>
    </div>

    <div class="row g-5">
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your cart</span>
          <span class="badge bg-primary rounded-pill"><?=$countCartItems ?></span>
        </h4>
        <ul class="list-group mb-3">
        <?php foreach( $cartItems as $cartItem):?>
        <?php include __DIR__.'/checkoutItem.php';?>
    <?php endforeach;?>
    <li class="list-group-item d-flex justify-content-between bg-light">
            <div class="text-success">
              <h6 class="my-0">Promo code</h6>
              <small>EXAMPLECODE</small>
            </div>
            <span class="text-success">???$5</span>
    <li class="list-group-item d-flex justify-content-between">
            <span>Total (EURO)</span>
            <strong><?=number_format($cartSum/1,2,","," ")?> &#8364</strong>
          </li>
          </li>
        </ul>

        <form class="card p-2" method="POST" action="index.php/checkout">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Promo code">
            <button type="submit" class="btn btn-secondary">Redeem</button>
          </div>
      </div>
      <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Billing address</h4>
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstname"  class="form-label">First name</label>
              <input name="firstname"  type="text" class="form-control" id="firstname" placeholder="" value="" required="">
              <div class="invalid-feedback">
                Please enter your first name.
              </div>
            </div>

            <div class="col-sm-6">
              <label for="lastname" class="form-label">Last name</label>
              <input name="lastname" type="text" class="form-control" id="lastname" placeholder="" value="" required="">
            </div>

            <div class="col-12">
              <label for="address1" class="form-label">Address</label>
              <input name="address1" type="text" class="form-control" id="address1" placeholder="1234 Main St" required="">
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="col-12">
              <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
              <input name="address2" type="text" class="form-control" id="address2" placeholder="Apartment or suite">
            </div>

            <div class="col-md-5">
              <label for="country" class="form-label">Country</label>
              <input name="country" type="text" class="form-control" id="country" placeholder="Germany" required="">
              <div class="invalid-feedback">
                Please select a valid country.
              </div>
            </div>
    
            <div class="col-md-4">
              <label for="city" class="form-label">City</label>
              <input name="city" type="text" class="form-control" id="city" placeholder="Berlin" required="">
              <div class="invalid-feedback">
                Please provide a valid state.
              </div>
            </div>

            <div class="col-md-3">
              <label for="zipCode" class="form-label">Zip</label>
              <input name="zipCode" type="text" class="form-control" id="zipCode" placeholder="" required="">
              <div class="invalid-feedback">
                Zip code required.
              </div>
            </div>
          </div>

          
          <hr class="my-4">

          <section class="container" id="selectDeliveryAdress">
  <?php require_once __DIR__.'/addressList.php'?>
 </section>

        
          <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
        </form>
      </div>
    </div>
  </main>

  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2017???2022 Company Name</p>
    <ul class="list-inline">
      <li class="list-inline-item"><a href="#">Privacy</a></li>
      <li class="list-inline-item"><a href="#">Terms</a></li>
      <li class="list-inline-item"><a href="#">Support</a></li>
    </ul>
  </footer>
</div>

    <script src="../Webshop/javaScript/form-validation.js"></script>
    <script src="../Webshop/javaScript/validCreditCardNumber.js"></script>
  </body>
</html>
