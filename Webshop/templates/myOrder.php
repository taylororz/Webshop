<?php require_once __DIR__.'/header.php'?>
<section class="container-fluid" id="myOrder">
    
     <h2 style="text-align: center;">My Order</h2>
     <div class="container-fluid col-11" >
     <div class="card" style="text-align: center;">

     <table class="table" >
    <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Order Nr</th>
      <th scope="col" style="text-align: center;">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($orderId as $orderId):?>
    <tr>
      <td>
        <?=$orderId['orderDate']?></td>
      <td><?=$orderId['id']?></td>
      <td>
      <a class="btn btn-primary" href="./index.php/myOrderDetail/<?=$userId?>/<?=$orderId['id']?>" >Details</a>
      <a class="btn btn-success" href="./index.php/myOrder/again/<?=$userId?>/<?=$orderId['id']?>"> Order Again</button>
      </td>
    </tr>
    <?php endforeach;?>
    <?php if(empty($orderId)){
            echo "You don't have any order.";
        }?>
    </tbody>
</table>

<?php require_once __DIR__.'/footer.php'?>