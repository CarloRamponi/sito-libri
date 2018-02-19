<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 11/02/18
 * Time: 11.04
 */
?>

<?php include_once "includes.html"; ?>

<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="<?php echo ($pageNum != 1)? "libri.php" : "#" ?>">BooksReviews</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php echo ($pageNum == 1)? "active" : ""?>">
                <a class="nav-link" href="<?php echo ($pageNum != 1)? "libri.php" : "#" ?>">Libri</a>
            </li>
            <li class="nav-item <?php echo ($pageNum == 2)? "active" : ""?>">
                <a class="nav-link" href="<?php echo ($pageNum != 2)? "mieRecensioni.php" : "#" ?>">Le mie recensioni</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="userNav" aria-expanded="false"><?php echo $user; ?><span class="caret"></span></a>
                <div class="dropdown-menu" aria-labelledby="userNav">
                    <a class="dropdown-item" href="index.php?req=logout">Esci</a>
                </div>
            </li>
        </ul>
    </div>
</nav>