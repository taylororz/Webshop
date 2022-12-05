<!DOCTYPE html>
<html lang="de">
<head>
    <title>Webshop</title>
    <meta charset="utf-8">
    <base href="<?=$baseUrl ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
<?php include __DIR__.'/navbar.php'?>
<header class="p-5 mb-4 bg-light rounded-3">
    <div class="container">
        <h1>Willkommen auf meinem Online Shop</h1>
    </div>
</header>
<section class="container" id="loginForm">
 <form action="index.php/login" method="POST">
   <div class="card">
    <div class="card-header">
        Login
    </div>
    <div class="card-body">
         <?php if($hasErrors):?>
            <div class="alert alert-danger" role="alert">
                <?php foreach($errors as $errorMessage):?>
                    <p><?=$errorMessage?></p>
                <?php endforeach?>
            </div>
        <?php endif;?>
        <div class="form-group">
            <label for ="username">Username</label>
            <input type="text" value="<?=$username?>" name="username" id="username" class="form-control">
        </div>
        <div class="form-group">
            <label for ="password">Password</label>
            <input type="password" value="<?=$password?>" name="password" id="password" class="form-control">
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-success" type="submit">Login</button>
    </div>
   </dív>   
</form>    
</section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>