<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 19/02/18
 * Time: 15.20
 */

include_once "connessione.php";
include_once "checkLogin.php";

$user = checkLogin($conn);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$utente = $_SESSION['id_utente'];

?>

<html>

<head>
    <title>BooksReviews - Le mie recensioni</title>

    <?php include_once "includes.html"; ?>

    <style>
        .myCell{
            min-width: 150px;
        }
    </style>

</head>

<body>

<?php
    $pageNum = 2;
    include "navbar.php";
?>

<div class="container">

    <br><br><br><br><br><br>

    <div class="row">
        <div class="col-sm-12">

            <h1>Le mie recensioni</h1><br>

            <?php

                $ris = $conn->query("SELECT * FROM users WHERE id=".$utente);
                $row = $ris->fetch_array(MYSQLI_ASSOC);

                echo "<h3>".$row['nome']." ".$row['cognome']."</h3><br>";

            ?>

            <br>

            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="myCell">ISBN</th>
                    <th class="myCell">Titolo</th>
                    <th class="myCell">Autore</th>
                    <th class="myCell">Data</th>
                    <th class="myCell">Voto</th>
                    <th class="myCell">Recensione</th>
                </tr>
                </thead>
                <?php

                    $ris = $conn->query("SELECT l.isbn, l.titolo, l.autore, r.data, r.voto, r.descrizione FROM recensioni r JOIN libri l ON r.isbn = l.isbn WHERE r.id_utente=".$utente);

                    if($ris->num_rows == 0)
                        echo "<td colspan='6'>Ancora nessuna recensione qui...</td>";
                    else {
                        while ($row = $ris->fetch_array(MYSQLI_ASSOC)){
                            echo "<tr>";
                            echo "<td><a href='libro.php?isbn=".$row['isbn']."'>".$row['isbn']."</a></td>";
                            echo "<td>".$row['titolo']."</td>";
                            echo "<td>".$row['autore']."</td>";
                            echo "<td>".$row['data']."</td>";
                            echo "<td>";
                            for($i=0; $i<(int)$row['voto']; $i++)   //stampo le stelline
                                echo '<i class="fas fa-star"></i>';
                            echo "</td>";
                            echo "<td>".$row['descrizione']."</td>";
                            echo "</tr>";
                        }
                    }

                ?>
            </table>

            <br><br><br><br><br><br>

        </div>
    </div>

</div>

</body>

</html>
