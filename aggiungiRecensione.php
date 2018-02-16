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

//TODO voto!!!!

if(isset($_GET['isbn']) && ($isbn = $_GET['isbn']) != "" && isset($_POST['descrizione']) && ($descrizione = $_POST['descrizione']) != "" && isset($_POST['voto']) && ($voto = $_POST['voto']) != "" ){

    $cliente = $_SESSION['id_utente'];

    $prep = $conn->prepare("INSERT INTO recensioni (id_utente, isbn, descrizione, voto, data) VALUES (?, ?, ?, ?, CURDATE())");
    $prep->bind_param('sssss', $cliente, $isbn, $descrizione, $voto);
    $prep->execute();
    $ris = $prep->get_result();

    if($ris == 0){

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
    $pageNum = 1;
    include "navbar.php";
?>

<div class="container">

    <div class="row">

        <div class="col-lg-6 offset-lg-3 offset-md-2 col-md-8 col-sm-12">

            <br><br><br><br>

            <h1>Aggiungi recensione</h1>

            <hr>

            <form method="post" id="recForm">

                <h3>Voto:</h3>

                <div class="fieldset">

                    <div class="form-group" id="voti">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="voto1" name="voto" class="custom-control-input" checked>
                            <label class="custom-control-label" for="voto1">1</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="voto2" name="voto" class="custom-control-input">
                            <label class="custom-control-label" for="voto2">2</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="voto3" name="voto" class="custom-control-input">
                            <label class="custom-control-label" for="voto3">3</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="voto4" name="voto" class="custom-control-input">
                            <label class="custom-control-label" for="voto4">4</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="voto5" name="voto" class="custom-control-input">
                            <label class="custom-control-label" for="voto5">5</label>
                        </div>
                    </div>

                    <div class="form-group has-danger">
                        <label for="recensione" class="form-control-label">Recensione</label>
                        <textarea class="form-control" name="recensione" id="recensione" rows="10"></textarea>
                        <div class="invalid-feedback" id="recensioneError">Campo obbligatorio!</div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success" type="button" onclick="formValidation()">Inserisci</button>
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

