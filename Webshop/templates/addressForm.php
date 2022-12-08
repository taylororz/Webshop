<form mehtod="POST" action="index.php/deliveryAddress/add">
    <div class="card">
    <div class="card-header">
        Neue Address
    </div>
    <div class="card-body">
        <?php if($hasErrors):?>
            <ul class="alert alert-danger" role="alert">
            <?php foreach($errors as $errorMessage):?>
                   <li><?=$errorMessage?></li>
                   <?php endforeach?>
                </ul>
                <?php endif;?>
        <div class="form-group">
            <label for="recipient">Empfänger</label>
            <input name="recipient" class="form-control" id="recipient">
        </div>
        <div class="form-group">
            <label for="street">Straße</label>
            <input name="street" class="form-control" id="street">
        </div>
        <div class="form-group">
            <label for="streetNr">Hausnummer</label>
            <input name="streetNr" class="form-control" id="streetNr">
        </div>
        <div class="form-group">
            <label for="city">Stadt</label>
            <input name="city" class="form-control" id="city">
        </div>
        <div class="form-group">
            <label for="zipCode">PLZ</label>
            <input name="zipCode" class="form-control" id="zipCode">
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-success">Speichern</button>
    </div>
    </div>
</form>