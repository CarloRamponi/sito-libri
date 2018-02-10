<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 10/02/18
 * Time: 14.20
 */

include_once "connessione.php";
include_once "checkLogin.php";

checkLogin($conn, true);

if(isset($_POST['name']) && ($name = $_POST['name']) != "" && isset($_POST['surname']) && ($surname = $_POST['surname']) != "" && isset($_POST['user']) && ($user = $_POST['user']) != "" && isset($_POST['passwd']) && ($passwd = $_POST['passwd']) != "" && isset($_POST['confirmPasswd']) && ($confirmPasswd = $_POST['confirmPasswd']) != ""){

    $prep = $conn->prepare("SELECT * FROM users WHERE username = ?;");
    $prep->bind_param('s', $user);
    $prep->execute();
    $ris = $prep->get_result();

    if($ris->num_rows != 0){
        $usernameExists = true;
    } else {

        $salt = hash("sha256", rand());
        $hashedPasswd = hash("sha256", $salt . $passwd);

        $prep = $conn->prepare("INSERT INTO users (nome, cognome, username, passwd, salt) VALUES (?, ?, ?, ?, ?)");
        $prep->bind_param('sssss', $name, $surname, $user, $hashedPasswd, $salt);
        $prep->execute();
        $ris = $prep->get_result();

        if($ris == 0){

            $_SESSION['user'] = $user;
            header("Location: home.php");

        } else {
            die("Errore");
        }

    }

}

?>

<html>

<head>
    <title>BooksReviews - Registrazione</title>

    <link rel="stylesheet" href="https://bootswatch.com/_vendor/bootstrap/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body>

<div class="container">

    <div class="row">

        <div class="col-lg-6 offset-lg-3 offset-md-2 col-md-8 col-sm-12">

            <br><br><br>

            <h1>Registrati</h1>

            <hr class="black">

            <form method="post" id="registerForm">

                <div class="fieldset">

                    <div class="form-group has-danger">
                        <label for="name" class="form-control-label">Nome</label>
                        <input class="form-control" type="text" name="name" id="name">
                        <div class="invalid-feedback" id="nameError">Campo obbligatorio!</div>
                    </div>

                    <div class="form-group has-danger">
                        <label for="surname" class="form-control-label">Cognome</label>
                        <input class="form-control" type="text" name="surname" id="surname">
                        <div class="invalid-feedback" id="surnameError">Campo obbligatorio!</div>
                    </div>

                    <div class="form-group has-danger">
                        <label for="user" class="form-control-label">Scegli un username</label>
                        <input class="form-control" type="text" name="user" id="user" <?php if(isset($usernameExists) && $usernameExists) echo "is_invalid"; ?>>
                        <div class="invalid-feedback" id="userError">Username già presente!</div>
                    </div>
                    <div class="form-group has-danger">
                        <label for="passwd" class="form-control-label">Scegli una password</label>
                        <input class="form-control" type="password" name="passwd" id="passwd">
                        <div class="invalid-feedback" id="passwdError"></div>
                    </div>
                    <div class="form-group has-danger">
                        <label for="confirmPasswd" class="form-control-label">Conferma la password</label>
                        <input class="form-control" type="password" name="confirmPasswd" id="confirmPasswd">
                        <div class="invalid-feedback" id="confirmPasswdError"></div>
                    </div>
                    <div class="form-group">
                        Hai già un account? <a href="index.php">entra</a>!
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success" type="button" onclick="formValidation()">Registrati</button>
                        <button class="btn btn-danger" type="reset">Annulla</button>
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

    function checkPassword (str)  {
        val = $("#"+str);
        if(val.val() === "") {
            $("#"+str+"Error").text("Campo obbligatorio!");
            val.addClass("is-invalid");
            return false;
        } else {
            if (val.val().length < 8) {
                $("#" + str + "Error").text("La password deve essere lunga almeno 8 caratteri!");
                val.addClass("is-invalid");
                return false;
            } else {
                val.removeClass("is-invalid");
                return true;
            }
        }
    }

    function checkConfirmPassword (str) {

        val = $("#"+str);
        if(val.val() === "") {
            $("#"+str+"Error").text("Campo obbligatorio!");
            val.addClass("is-invalid");
            return false;
        } else {
            if (val.val() !== $("#passwd").val()) {
                $("#" + str + "Error").text("Le password devono coincidere!");
                val.addClass("is-invalid");
                return false;
            } else {
                val.removeClass("is-invalid");
                return true;
            }
        }

    }

    $("#name").focusout( function () { requiredItem("name") } );
    $("#surname").focusout( function () { requiredItem("surname") } );
    $("#user").focusout( function () { requiredItem("user") } );
    $("#passwd").focusout( function () { checkPassword("passwd") } );
    $("#confirmPasswd").focusout( function () { checkConfirmPassword("confirmPasswd") } );

    function formValidation () {
        if(requiredItem("name") && requiredItem("surname") && requiredItem("user") && checkPassword("passwd") && checkConfirmPassword("confirmPasswd") )
            $("#registerForm").submit();
    }

    $("#registerForm").keypress(function (event) {
        if (event.which == 13 || event.keyCode == 13) {
            formValidation();
            return false;
        }
        return true;
    });

</script>

</body>

</html>

