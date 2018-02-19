<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 12/02/18
 * Time: 17.14
 */

include_once "connessione.php";
include_once "checkLogin.php";

$user = checkLogin($conn);

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

            <?php

                $ris = $conn->query("SELECT * FROM libri WHERE isbn=".$isbn);
                $row = $ris->fetch_array(MYSQLI_ASSOC);

                echo "<h1>".$row['titolo']."</h1><br>";
                echo "<h3>".$row['autore']."</h3><br>";

            ?>

            <br>

            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="myCell">Utente</th>
                    <th class="myCell">Data</th>
                    <th class="myCell">Voto</th>
                    <th class="myCell">Recensione</th>
                </tr>
                </thead>
                <?php

                    $ris = $conn->query("SELECT nome, cognome, voto, descrizione, data FROM recensioni r JOIN users u ON r.id_utente = u.id WHERE isbn=".$isbn);

                    if($ris->num_rows == 0)
                        echo "<td colspan='3'>Nessuna recensione per questo libro</td>";
                    else {
                        while ($row = $ris->fetch_array(MYSQLI_ASSOC)){
                            echo "<tr>";
                            echo "<td>".$row['nome']." ".$row['cognome']."</td>";
                            echo "<td>".$row['data']."</td>";
                            echo "<td>";
                            for($i=0; $i<(int)$row['voto']; $i++)   //stampo le stelline
                                echo '<i class="fas fa-star"></i>';
                            echo "</td>";
                            echo "<td>".$row['descrizione']."</td>";
                            echo "<tr>";
                        }
                    }

                ?>
            </table>

            <br><br>

            <?php

                $ris = $conn->query("SELECT * FROM recensioni WHERE id_utente=".$_SESSION['id_utente']." AND isbn=".$isbn);

                if($ris->num_rows == 0)
                    $recensito = false;
                else
                    $recensito = true;


            ?>


            <a href="aggiungiRecensione.php?isbn=<?php echo $isbn; ?>&action=<?php echo ($recensito)? "edit" : "add"; ?>" class="btn btn-success"><?php echo ($recensito)? "Modifica" : "Aggiungi"; ?> recensione</a>
            <?php if($recensito) { ?> <a href="eliminaRecensione.php?isbn=<?php echo $isbn; ?>" class="btn btn-danger">Elimina recensione</a> <?php } ?>
            <a href="libri.php" class="btn btn-danger">Indietro</a>

            <br><br><br><br><br>

        </div>
    </div>

</div>

</body>

</html>
