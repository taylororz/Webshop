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
            <span class="text-success">−$5</span>
    <li class="list-group-item d-flex justify-content-between">
            <span>Total (EURO)</span>
            <strong><?=number_format($cartSum/1,2,","," ")?> &#8364</strong>
          </li>
          </li>
        </ul>

        <form class="card p-2 method="POST" action="index.php/checkout">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Promo code">
            <button type="submit" class="btn btn-secondary">Redeem</button>
          </div>
      </div>
      <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Billing address</h4>
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstname" for="validationCustom01" class="form-label">First name</label>
              <input name="firstname" id="validationCustom01" type="text" class="form-control" id="firstname" placeholder="" value="" required="">
              <div class="invalid-feedback">
                Please enter your first name.
              </div>
            </div>

            <div class="col-sm-6">
              <label for="lastname" class="form-label">Last name</label>
              <input name="lastname" type="text" class="form-control" id="lastname" placeholder="" value="" required="">
            </div>

            <div class="col-12">
              <label for="address1 validationCustom02" class="form-label">Address</label>
              <input name="address1" type="text" class="form-control" id="address1 validationCustom02" placeholder="1234 Main St" required="">
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="col-12">
              <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
              <input name="address2" type="text" class="form-control" id="address2" placeholder="Apartment or suite">
            </div>

            <div class="col-md-5">
              <label for="country validationCustom03" class="form-label">Country</label>
              <input name="country" type="text" class="form-control" id="country validationCustom03" placeholder="Germany" required="">
              <div class="invalid-feedback">
                Please select a valid country.
              </div>
            </div>
    
            <div class="col-md-4">
              <label for="states validationCustom04" class="form-label">State</label>
              <input name="states" type="text" class="form-control" id="states validationCustom04" placeholder="Baden-Württemberg" required="">
              <div class="invalid-feedback">
                Please provide a valid state.
              </div>
            </div>

            <div class="col-md-3">
              <label for="zipCode validationCustom05" class="form-label">Zip</label>
              <input name="zipCode" type="text" class="form-control" id="zipCode validationCustom05" placeholder="" required="">
              <div class="invalid-feedback">
                Zip code required.
              </div>
            </div>
          </div>

          <hr class="my-4">

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="same-address">
            <label class="form-check-label" for="same-address">Shipping address is the same as my billing address</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="save-info">
            <label class="form-check-label" for="save-info">Save this information for next time</label>
          </div>

          <div class="form-check">
          <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required="">
          <label class="form-check-label" for="invalidCheck">
            Agree to terms and conditions
          </label>
          <div class="invalid-feedback">
            You must agree before submitting.
          </div>
          </div>

          <hr class="my-4">

          <h4 class="mb-3">Payment</h4>

          <div class="my-3">
            <div class="form-check">
              <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
              <label class="form-check-label" for="credit">Credit card</label>
            </div>
            <div class="form-check">
              <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>
              <label class="form-check-label" for="debit">Debit card</label>
            </div>
         
          <div class="row gy-3">
            <div class="col-md-6">
              <label for="cc-name" class="form-label">Name on card</label>
              <input type="text" class="form-control" id="cc-name" placeholder="" required>
              <small class="text-muted">Full name as displayed on card</small>
              <div class="invalid-feedback">
                Name on card is required
              </div>
            </div>

            <div class="col-md-6">
              <label for="cc-number" class="form-label">Credit card number</label>
              <input type="text" onkeyup="update(this.value);" class="form-control" id="cc-number" placeholder="" required>
              <img src="Pics/1.png" id="img" width="20px" height="20px">
              <span style="color:red;" id="invalid1"></span>
              <div class="invalid-feedback">
                Credit card number is required
              </div>
            </div>
            
            <div class="col-md-6">
              <label for="cc-expiration" class="form-label">Expiration</label>
              <div class="col-md-3">
              <select class="form-select" style="width:auto;" id="exMonth" title="select a month">
                <option value = "0"> Month</option>
                <option value="01">Jan</option>
                <option value="02">Feb</option>
                <option value="03">Mar</option>
                <option value="04">Apr</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">Aug</option>
                <option value="09">Sep</option>
                <option value="10">Oct</option>
                <option value="11">Nov</option>
                <option value="12">Dec</option>
              </select>
              </div>
              <div class="col-md-3">
              <select class="form-select" id="exYear" style="width:auto;" title="select a year">
                <option value = "0"> Year</option>
                <option value="2023">23</option>
                <option value="2024">24</option>
                <option value="2025">25</option>
                <option value="2026">26</option>
                <option value="2027">27</option>
                <option value="2028">28</option>
              </select>
              </div>
              <span style="color:red;" id="invalid2"></span>
              <div class="invalid-feedback">
                Expiration date required
              </div>
            </div>

            <div class="col-md-5">
              <label for="cc-cvv" class="form-label">CVV</label>
              <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
              <div class="invalid-feedback">
                Security code required
              </div>
            </div>
          </div>

          <hr class="my-4">
        
          <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
        </form>
      </div>
    </div>
  </main>

  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2017–2022 Company Name</p>
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
