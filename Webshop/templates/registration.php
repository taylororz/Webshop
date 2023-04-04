<?php require_once __DIR__.'/header.php'?>
<section id="registration" class="container">
<center>
    <form action="index.php/registration" method="POST">
        <div class="card text-center mb-3" style="width: 18rem;">
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
            <label for="firstname">Firstname</label>
            <input type="text" value="<?=$firstname?>" name="firstname" id="firstname" class="form-control" pattern="^[\u00C0-\u017Fa-zA-Z'][\u00C0-\u017Fa-zA-Z-' ]+[\u00C0-\u017Fa-zA-Z']?$">
          </div>
          <div class="form-group">
            <label for="lastname">Lastname</label>
            <input type="text" value="<?=$lastname?>" name="lastname" id="lastname" class="form-control" pattern="^[\u00C0-\u017Fa-zA-Z'][\u00C0-\u017Fa-zA-Z-' ]+[\u00C0-\u017Fa-zA-Z']?$">
          </div>
                <div class="form-group">
            <label for="username">Username</label>
            <input type="email" value="<?=$username?>" name="username" id="username" class="form-control" placeholder="Email" onInput="checkUsername()">
            <span id="check-username"></span>
          </div>
          <div class="form-group">
            <label for="usernameRepeat">Username repeat</label>
            <input type="email" value="<?=$usernameRepeat?>" name="usernameRepeat" id="usernameRepeat" class="form-control" placeholder="Email">
          </div>
            </div>
            <div class="card-footer">
          <button class="btn btn-success" type="submit" value="Submit">Create account</button>
        </div>
        </div>
    </form>
  </center>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"> </script>
<script>
function checkUsername(){
    jQuery.ajax({
        url:"./Ajax/checkuser.php",
        data:'username='+$("#username").val(),
        type:"POST",
        success:function(data){
            $("#check-username").html(data);
        },
        error:function(){}
    });
}</script>
<?php require_once __DIR__.'/footer.php'?>