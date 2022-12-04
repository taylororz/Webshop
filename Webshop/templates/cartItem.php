<div class="col-3">
<img src="<?= $cartItem['pics']?>" class="productPicture" alt="products" width=255px height=160px>
</div>
<div class="col-4">
    <div><?=$cartItem['titel']?></div>
    <div><?=$cartItem['beschreibung']?></div>
</div>
<div class="col-1 text-center">
    <div> <?=$cartItem['quantity']?></div>
</div>
<div class="col-4 text-end">
    <span class="preis"><?=number_format ($cartItem['preis'],2,"," , " ") ?> &#8364 </span>
</div>