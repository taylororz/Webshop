

        <td width=255px height=160px>
         <img src="<?= $cartItem['pics']?>" class="card-img-top" alt="products"  >
      <td>
      <td>
         <div><?=$cartItem['titel']?></div>
      <td>
        <div >
        <a class="delete btn btn-danger" href="index.php/cart/delete/<?= $cartItem['product_id']?>" id="delete" name="delete"  ><i class="bi bi-x"></i></a>
        </div>
      </td>
      <td style="text-align: center;">
      <form action="index.php/cart/change/<?= $cartItem['product_id']?>" method="POST">
      <input type="number" id="addcart" value="<?=$cartItem['quantity']?>" min="1" name="addcart" id="addcart" style="width:48px;">
      </form>
      </td>
        <td style="text-align: center;">
        <div>
        <span class="preis" ><?=number_format ($cartItem['preis'],2,"," , " ") ?> &#8364 </span>
      </div>
      </td>


  
