<?php require_once __DIR__.'/header.php'?>

<section class="container" id="resetForm">
<center>
 <form action="index.php/resetpw" method="POST">
   <div class="card text-center mb-3" style="width: 18rem;">
    <div class="card-header">
        Reset Password
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
            <input type="text" value="<?=$username?>" name="username" id="username" class="form-control" placeholder="Email">
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-success" type="submit">Submit</button>
    </div>
   </dív>   
</form>    
</center>
<?php require_once __DIR__.'/footer.php'?>