<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
<nav class="navbar navbar-expand-lg bg-white">
    <div class="container">
    <a class="navbar-brand" href="index.php">My shop</a>
    <ul class="navbar-nav">
        <li class="nav-item">
            <?php if(isLoggedIn()):?>
                <a class="btn btn-danger" href="index.php/logout"><i class="bi bi-person"></i> Logout</a>
            <?php endif;?>
            <?php if(!isLoggedIn()):?>
                <a class="btn btn-success" href="index.php/login"><i class="bi bi-person"></i> Login</a>
            <?php endif?>
            <?php if(!isLoggedIn()):?>
                <a class="btn btn-success" href="index.php/registration"><i class="bi bi-vector-pen"></i> Registration</a>
            <?php endif?>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
			<li class="nav-item">
               <a class="btn btn-primary" href="./index.php/cart"> <i class="bi bi-cart"></i> Cart <span class="badge text-bg-light"><?=$countCartItems ?></span></a>
            </li>
    </ul>
    </div>
</nav>