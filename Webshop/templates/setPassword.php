<?php require_once __DIR__.'/header.php'?>

<section class="container" id="resetForm">
<center>
 <form action="index.php/account/setPassword/<?=$username?>" method="POST">
   <div class="card text-center mb-3" style="width: 18rem;">
    <div class="card-header">
        Set Password
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
            <label for ="password">Password</label>
            <input type="password" value="<?=$password?>" name="password" id="password1" class="form-control" placeholder="password" onkeyup="return validPassword()" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(.{9,15})$">
        </div>
        <div class="form-group">
            <label for ="passwordRepeat">Password repeat</label>
            <input type="password" value="<?=$passwordRepeat?>" name="passwordRepeat" id="passwordRepeat" class="form-control" placeholder="password again" >
        </div>
    </div>
    <div class="errors">
    <ul>
        <li id='upper'>at least 1 uppercase.</li>
        <li id='lower'>at least 1 lowercase.</li>
        <li id='number'>at least 1 number.</li>
        <li id='length'>at least 9 charecter.</li>
    </ul>
    <div>
    <div class="card-footer">
        <button class="btn btn-success" type="submit">Submit</button>
    </div>
   </dív>   
</form>    
</center>
<script type="text/javascript" src="./javaScript/valid.js"></script>
<?php require_once __DIR__.'/footer.php'?>