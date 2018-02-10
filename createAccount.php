<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 10/02/18
 * Time: 14.20
 */

include_once "connessione.php";

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

            <form method="post">

                <div class="fieldset">

                    <div class="form-group has-danger">
                        <label for="name" class="form-control-label">Nome</label>
                        <input class="form-control" type="text" name="name" id="name">
                        <div class="invalid-feedback">Campo obbligatorio!</div>
                    </div>

                    <div class="form-group has-danger">
                        <label for="surname" class="form-control-label">Cognome</label>
                        <input class="form-control" type="text" name="surname" id="surname">
                        <div class="invalid-feedback">Campo obbligatorio!</div>
                    </div>

                    <div class="form-group has-danger">
                        <label for="user" class="form-control-label">Scegli un username</label>
                        <input class="form-control" type="text" name="user" id="user">
                        <div class="invalid-feedback">Username già presente!</div>
                    </div>
                    <div class="form-group has-danger">
                        <label for="passwd" class="form-control-label">Scegli una password</label>
                        <input class="form-control" type="password" name="passwd" id="passwd">
                        <div class="invalid-feedback" id="passwdError"></div>
                    </div>
                    <div class="form-group has-danger">
                        <label for="confirmPasswd" class="form-control-label">Conferma la password</label>
                        <input class="form-control" type="password" name="confirmPasswd" id="confirmPasswd">
                        <div class="invalid-feedback" id="confirmPasswd"></div>
                    </div>
                    <div class="form-group">
                        Hai già un account? <a href="index.php">entra</a>!
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Registrati</button>
                        <button class="btn btn-danger" type="reset">Annulla</button>
                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

</body>

</html>

