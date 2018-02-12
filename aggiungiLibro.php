<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 10/02/18
 * Time: 14.20
 */

include_once "connessione.php";
include_once "checkLogin.php";

$user = checkLogin($conn);

if(isset($_POST['isbn']) && ($isbn = $_POST['isbn']) != "" && isset($_POST['title']) && ($title = $_POST['title']) != "" && isset($_POST['autore']) && ($autore = $_POST['autore']) != "" && isset($_POST['year']) && ($year = $_POST['year']) != "" && isset($_POST['genere']) && ($genere = $_POST['genere']) != ""){

    if(strlen($isbn) != 13)
        die("L'isbn deve essere di 13 caratteri");

    $prep = $conn->prepare("SELECT * FROM libri WHERE isbn = ?;");
    $prep->bind_param('s', $isbn);
    $prep->execute();
    $ris = $prep->get_result();

    if($ris->num_rows != 0){
        $isbnExists = true;
    } else {

        $prep = $conn->prepare("INSERT INTO libri (isbn, titolo, autore, annoUscita, genere) VALUES (?, ?, ?, ?, ?)");
        $prep->bind_param('sssss', $isbn, $title, $autore, $year, $genere);
        $prep->execute();
        $ris = $prep->get_result();

        if($ris == 0){
            header("Location: libri.php");
        } else {
            die("Errore");
        }

    }

}

?>

<html>

<head>
    <title>BooksReviews - Aggiunta libro</title>

    <link rel="stylesheet" href="https://bootswatch.com/_vendor/bootstrap/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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

                <h1>Aggiungi libro</h1>

                <hr class="black">

                <form method="post" id="addBookForm">

                    <div class="fieldset">

                        <div class="form-group has-danger has-success">
                            <label for="isbn" class="form-control-label">ISBN</label>
                            <input class="form-control <?php if(isset($isbnExists) && $isbnExists) echo "is-invalid"; ?>" type="text" name="isbn" id="isbn" value="<?php if(isset($isbn)) echo $isbn; ?>" >
                            <div class="invalid-feedback" id="isbnError">ISBN già presente!</div>
                            <div class="valid-feedback">ISBN valido!</div>
                        </div>
                        <div class="form-group has-danger">
                            <label for="title" class="form-control-label">Titolo</label>
                            <input class="form-control" type="text" name="title" id="title">
                            <div class="invalid-feedback" id="titleError"></div>
                        </div>
                        <div class="form-group has-danger">
                            <label for="autore" class="form-control-label">Autore</label>
                            <input class="form-control" type="text" name="autore" id="autore">
                            <div class="invalid-feedback" id="autoreError"></div>
                        </div>
                        <div class="form-group has-danger">
                            <label for="year" class="form-control-label">Anno di pubblicazione</label>
                            <input class="form-control" type="number" name="year" id="year" min="0" max="<?php echo date("Y"); ?>">
                            <div class="invalid-feedback" id="yearError"></div>
                        </div>
                        <div class="form-group has-danger">
                            <label for="genere" class="form-control-label">Genere</label>
                            <input class="form-control" type="text" name="genere" id="genere">
                            <div class="invalid-feedback" id="genereError"></div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="button" onclick="formValidation()">Aggiungi</button>
                            <a href="libri.php" class="btn btn-danger">Annulla</a>
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

<script>

    //form validation

    function requiredItem (str, minLength = 0, maxLength = 0) {
        val = $("#"+str);
        if(val.val() === "") {
            $("#"+str+"Error").text("Campo obbligatorio!");
            val.addClass("is-invalid").removeClass("is-valid");
            return false;
        }
        else {
            if(val.val().length < minLength) {
                $("#"+str+"Error").text("Lunghezza minima: "+minLength+"!");
                val.addClass("is-invalid").removeClass("is-valid");
                return false;
            } else if(maxLength !== 0 && val.val().length > maxLength) {
                $("#"+str+"Error").text("Lunghezza massima: "+maxLength+"!");
                val.addClass("is-invalid").removeClass("is-valid");
                return false;
            } else {
                val.removeClass("is-invalid");
                return true;
            }
        }
    };

    function checkYear (str) {
        val = $("#"+str);

        if(!requiredItem(str))
            return false;

        if(val.val() > new Date().getFullYear()) {
            $("#"+str+"Error").text("Non può essere nel futuro!");
            val.addClass("is-invalid").removeClass("is-valid");
            return false;
        } else if(val.val() < 1901) {
            $("#"+str+"Error").text("Vecchiotto sto libro eh!");
            val.addClass("is-invalid").removeClass("is-valid");
            return false;
        } else {
            val.removeClass("is-invalid");
            return true;
        }

    }

    function checkISBN (str) {

        if(!requiredItem("isbn", 13, 13))
            return false;

        xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function (ev) {
            if(this.readyState === 4 && this.status === 200) {
                var response = JSON.parse(this.responseText);
                if(response['request'] === 'isbnExists'){
                    if(response['response'] === true){
                        $("#"+str+"Error").text("ISBN già presente!");
                        $("#"+str).addClass("is-invalid").removeClass("is-valid");
                    } else {
                        $("#"+str).addClass("is-valid").removeClass("is-invalid");
                    }
                }
            }

        }

        xmlhttp.open("GET", "api.php?req=isbnExists&isbn="+$("#"+str).val());
        xmlhttp.send();

        return true;

    }

    $("#isbn").keyup( function () { checkISBN("isbn") } );
    $("#title").keyup( function () { requiredItem("title", 0, 120) } );
    $("#autore").keyup( function () { requiredItem("autore", 0, 80) } );
    $("#year").keyup( function () { checkYear("year") });
    $("#genere").keyup( function () { requiredItem("genere", 0, 60) } );

    function formValidation () {
        if(requiredItem("isbn", 13, 13) && requiredItem("title", 0, 120) && requiredItem("autore", 0, 80), requiredItem("genere", 0, 60), checkYear("year"))
            $("#addBookForm").submit();
    }

    $("#addBookForm").keypress(function (event) {
        if (event.which === 13 || event.keyCode === 13) {
            formValidation();
            return false;
        }
        return true;
    });

</script>

</body>

<script src="https://bootswatch.com/_vendor/bootstrap/dist/js/bootstrap.min.js"></script>

</html>

