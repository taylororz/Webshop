<?php require_once __DIR__.'/header.php'?>
<section id="registration" class="container">
    <form action="index.php/registration" method="POST">
        <div class="card">
            <div class="card-header">
                Registration
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
            <label for="username">Username</label>
            <input type="username" value="<?=$username?>" name="username" id="username" class="form-control">
          </div>
          <div class="form-group">
            <label for="usernameRepeat">Username repeat</label>
            <input type="usernameRepeat" value="<?=$usernameRepeat?>" name="usernameRepeat" id="usernameRepeat" class="form-control">
          </div>
            </div>
            <div class="card-footer">
          <button class="btn btn-success" type="submit">Create account</button>
        </div>
        </div>
    </form>
</section>
<?php require_once __DIR__.'/footer.php'?>