<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 10/02/18
 * Time: 14.20
 */

include_once "connessione.php";
include_once "checkLogin.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user = checkLogin($conn);

$utente = $_SESSION['id_utente'];

if(isset($_GET['action'])){ //si vuole modificare o aggiungere la recensione?
    if($_GET['action'] == "add")
        $action = 0;
    elseif ($_GET['action'] == "edit")
        $action = 1;
    else
        die("Errore");
} else {
    die("Errore");
}

if(isset($_GET['isbn'])){
    $isbn = $conn->real_escape_string($_GET['isbn']);
} else {
    die("ISBN richiesto");
}

if($action){    //se si vuole modificare prendo i valori precedentemente inseriti

    $ris = $conn->query("SELECT voto, descrizione FROM recensioni WHERE isbn=".$isbn." AND id_utente=".$utente);
    $row = $ris->fetch_array(MYSQLI_ASSOC);

    $voto = $row['voto'];
    $desc = $row['descrizione'];

}

if(isset($_POST['recensione']) && ($descrizione = $conn->real_escape_string($_POST['recensione'])) != "" && isset($_POST['voto']) && ($voto = $conn->real_escape_string($_POST['voto'])) != "" ){


    if(!$action) {  //aggiungi
        $ris = $conn->query("INSERT INTO recensioni (id_utente, isbn, descrizione, voto, data) VALUES (".$utente.", '".$isbn."', '".$descrizione."', ".$voto.", CURDATE())");
    } else {    //modifica
        $ris = $conn->query("UPDATE recensioni SET voto=".$voto.", descrizione='".$descrizione."', data=CURDATE() WHERE isbn='".$isbn."' AND id_utente=".$utente);
    }

    if($ris){
        header("Location: libro.php?isbn=".$isbn);
    } else {
        die("Errore");
    }

}

?>

<html>

<head>
    <title>BooksReviews - Aggiungi Recensione</title>

    <?php include_once "includes.html"; ?>

</head>

<body>

<?php
    include "navbar.php";
?>

<div class="container">

    <div class="row">

        <div class="col-sm-12">

            <br><br><br><br><br>

            <?php

            $ris = $conn->query("SELECT * FROM libri WHERE isbn=".$isbn);
            $row = $ris->fetch_array(MYSQLI_ASSOC);

            echo "<h1>".$row['titolo']."</h1><br>";
            echo "<h3>".$row['autore']."</h3><br>";

            ?>

            <hr>

            <br><br>

        </div>

        <div class="col-lg-6 offset-lg-3 offset-md-2 col-md-8 col-sm-12">

            <h1><?php echo ($action)? "Modifica" : "Aggiungi"; ?> recensione</h1>

            <hr>

            <form method="post" id="recForm">

                <h3>Voto:</h3>

                <div class="fieldset">

                    <div class="btn-group btn-group-toggle my-2" data-toggle="buttons">
                        <label class="btn btn-primary <?php echo (!$action)? "active" : (($voto == 1)? "active" : "") ?>">
                            <input type="radio" name="voto" id="voto1" value="1" autocomplete="off" <?php echo (!$action)? "checked" : (($voto == 1)? "checked" : "") ?>> 1
                        </label>
                        <label class="btn btn-primary <?php echo ($action)? (($voto == 2)? "active" : "") : "" ?>">
                            <input type="radio" name="voto" id="voto2" value="2" autocomplete="off" <?php echo ($action)? (($voto == 2)? "checked" : "") : "" ?>> 2
                        </label>
                        <label class="btn btn-primary <?php echo ($action)? (($voto == 3)? "active" : "") : "" ?>">
                            <input type="radio" name="voto" id="voto3" value="3" autocomplete="off" <?php echo ($action)? (($voto == 3)? "checked" : "") : "" ?>> 3
                        </label>
                        <label class="btn btn-primary <?php echo ($action)? (($voto == 4)? "active" : "") : "" ?>">
                            <input type="radio" name="voto" id="voto4" value="4" autocomplete="off" <?php echo ($action)? (($voto == 4)? "checked" : "") : "" ?>> 4
                        </label>
                        <label class="btn btn-primary <?php echo ($action)? (($voto == 5)? "active" : "") : "" ?>">
                            <input type="radio" name="voto" id="voto5" value="5" autocomplete="off" <?php echo ($action)? (($voto == 5)? "checked" : "") : "" ?>> 5
                        </label>
                    </div>

                    <div class="form-group has-danger">
                        <label for="recensione" class="form-control-label">Recensione</label>
                        <textarea class="form-control" name="recensione" id="recensione" rows="10"><?php echo ($action)? $desc : "" ?></textarea>
                        <div class="invalid-feedback" id="recensioneError">Campo obbligatorio!</div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success" type="button" onclick="formValidation()"><?php echo ($action)? "Modifica" : "Aggiungi" ?></button>
                        <a href="libro.php?isbn=<?php echo $isbn; ?>" class="btn btn-danger">Annulla</a>
                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

    //form validation

    function requiredItem (str) {
        val = $("#"+str);
        if(val.val() === "") {
            $("#"+str+"Error").text("Campo obbligatorio!");
            val.addClass("is-invalid");
            return false;
        }
        else {
            val.removeClass("is-invalid");
            return true;
        }
    };


    $("#recensione").focusout( function () { requiredItem("recensione") } );

    function formValidation () {
        if(requiredItem("recensione"))
            $("#recForm").submit();
    }

    $("#recForm").keypress(function (event) {
        if (event.which === 13 || event.keyCode === 13) {
            formValidation();
            return false;
        }
        return true;
    });

</script>

</body>

</html>

