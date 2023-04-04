<?php require_once __DIR__.'/header.php'?>

<section class="container" id="activate">
    <?php if($hasFlashMessage):?>
  <div class="alert alert-success" role="alert">
    <?php foreach($flashMessage as $message):?>
        <p><?= $message?></p>
    <?php endforeach;?>
    <?php endif ?>
  </div>
</section>

<center>
 <form action="index.php/verify/<?=$username?>" method="POST">
   <div class="card text-center mb-3" style="width: 18rem;">
    <div class="card-header">
        Verify Two-Factor-Authification
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
            <input type="otp2" value="<?=$otp?>" name="otp2" id="otp2" class="form-control" placeholder="OTP">
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-success" type="submit" name="login" value="Login" onclick="findDimensions(); getOSinfo()" >Submit</button>
        <?php 
        $_COOKIE['Resolution']="";
        $_COOKIE['OS']="";
        $pass_value1= $_COOKIE['Resolution'];
        $pass_value2= $_COOKIE['OS'];
        ?>
    </div>
   </dív>   
</form>    
</center>

<?php require_once __DIR__.'/footer.php'?>
<script src="./javaScript/Os.js"></script>

