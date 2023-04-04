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
    <div id="users">Username: <?= $username ?></div>
    <div id="registerDate">Reset Password date: <span class="time"><?=$activity?></span></div>
    </div>
    </div>
 </div>
  <div class="card-body" id="content">
    <p>Hi <?= $name['firstname'] ?> <?= $name['lastname'] ?>,</p>
    <p>You request a reset of password.<br />
    To activate your account, click on the button:</p>
    <p><a href="<?= $activationLink ?>" class="btn btn-success" role="button">Change password now</a></p>
    <p>For manual changing please use the following code:</p>
    <p><b>Your link</b> <a href="<?=$projectUrl ?>/index.php/login">Login</a></p>
    <p><b>Your username:</b> <?= $username ?><br />
      <b>Your Onetime Password:</b> <?=$activationKey?></p>
    <p>
      <hr />
    </p>
    <p>Best regards</p>
    <p>Myshop - Team</p>
  </div>
<?php require_once __DIR__.'/footer.php'?>