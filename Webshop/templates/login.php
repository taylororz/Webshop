<?php require_once __DIR__.'/header.php'?>

<section class="container" id="loginForm">
<center>
 <form action="index.php/login" method="POST">
   <div class="card text-center mb-3" style="width: 18rem;">
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
            <input type="email" value="<?=$username?>" name="username" id="username" class="form-control" placeholder="Email">
        </div>
        <div class="form-group">
            <label for ="password">Password</label>
            <input type="password" value="<?=$password?>" name="password" id="password" class="form-control" placeholder="Password">
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-success" type="submit" name="login" value="Login" onclick="findDimensions(); getOSinfo()">Login</button>
    </div>
   </dív>   
</form>    
<?php 
        $_COOKIE['Resolution']="";
        $_COOKIE['OS']="";
        $pass_value1= $_COOKIE['Resolution'];
        $pass_value2= $_COOKIE['OS'];
        ?>
<a href="index.php/resetpw">Forgot password?</a>
</center>
<?php require_once __DIR__.'/footer.php'?>
<script src="./javaScript/Os.js"></script>


