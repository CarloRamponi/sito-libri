<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 12/02/18
 * Time: 17.14
 */

include_once "connessione.php";
include_once "checkLogin.php";

if(isset($_GET['isbn'])){
    $isbn = $_GET['isbn'];
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

            <a href="aggiungiRecensione.php?isbn=<?php echo $isbn; ?>" class="btn btn-success">Aggiungi recensione</a>

        </div>
    </div>

</div>

</body>

</html>
