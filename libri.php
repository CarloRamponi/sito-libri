<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 10/02/18
 * Time: 23.09
 */

include_once "connessione.php";
include_once "checkLogin.php";

$user = checkLogin($conn);

?>


<html>

<head>
    <title>BooksReviews - Libri</title>

    <link rel="stylesheet" href="https://bootswatch.com/_vendor/bootstrap/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

    <body>

        <?php
            $pageNum = 2;
            include "navbar.php";
        ?>

        <div class="container">

            <div class="row">

            </div>

        </div>

    </body>

<script src="https://bootswatch.com/_vendor/bootstrap/dist/js/bootstrap.min.js"></script>

</html>