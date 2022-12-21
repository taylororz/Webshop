<div class="row">
    <?php foreach($deliveryAddresses as $deliveryAddress):?>
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <p>
                    <strong class="firstname"><?= $deliveryAddress['firstname']?></strong>
                    <strong class="lasttname"><?= $deliveryAddress['lastname']?></strong>
                    </p>
                    <p class="address1">
                        <?= $deliveryAddress['address1'] ?> 
                    </p>
                    <p class="address2">
                        <?= $deliveryAddress['address2'] ?> 
                    </p>
                    <p>
                     <?= $deliveryAddress['zipCode'] ?> <?= $deliveryAddress['city'] ?> 
                    </p>
                    <p><?= $deliveryAddress['country'] ?></p>
                    <a class="card-link" href="index.php/success/<?= $deliveryAddress['id']?>">select</a>
                </div>
            </div>
        </div>
        <?php endforeach ?>
</div>