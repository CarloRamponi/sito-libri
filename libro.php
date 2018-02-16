<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 12/02/18
 * Time: 17.14
 */

include_once "connessione.php";
include_once "checkLogin.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_GET['isbn'])){
    $isbn = $conn->real_escape_string($_GET['isbn']);
} else {
    die("Errore!");
}

?>

<html>

<head>
    <title>BooksReviews - Libri</title>

    <?php include_once "includes.html"; ?>

    <style>
        .myCell{
            min-width: 150px;
        }
    </style>

</head>

<body>

<?php
    $pageNum = 1;
    include "navbar.php";
?>

<div class="container">

    <br><br><br><br><br><br>

    <div class="row">
        <div class="col-sm-12">

            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="myCell">Utente</th>
                    <th class="myCell">Voto</th>
                    <th class="myCell">Recensione</th>
                </tr>
                </thead>
                <tbody>
                    <?php //stampa recensioni ?>
                </tbody>
            </table>

            <br><br>

            <?php

                $ris = $conn->query("SELECT * FROM recensioni WHERE id_utente=".$_SESSION['id_utente']." AND isbn=".$isbn);

                if($ris->num_rows == 0)
                    $recensito = false;
                else
                    $recensito = true;


            ?>


            <a href="aggiungiRecensione.php?isbn=<?php echo $isbn; ?>" class="btn btn-success <?php if($recensito) echo "disabled"; ?>">Aggiungi recensione</a>

        </div>
    </div>

</div>

</body>

</html>
