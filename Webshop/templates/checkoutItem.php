<li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0"><?=$cartItem['titel']?></h6>
              <small class="text-muted"><?=$cartItem['beschreibung']?></small>
            </div>
            <span class="text-muted"><?=number_format ($cartItem['preis'],2,"," , " ") ?> &#8364 </span>
          </li>
          
         