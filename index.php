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

if(isset($_POST['user']) && ($user = $_POST['user']) != "" && isset($_POST['passwd']) && ($passwd = $_POST['passwd']) != ""){

    $prep = $conn->prepare("SELECT * FROM users WHERE username = ?;");
    $prep->bind_param('s', $user);
    $prep->execute();
    $ris = $prep->get_result();

    if ($ris->num_rows == 0) {
        $usernameNotFound = true;
    } else {
        $row = $ris->fetch_array(MYSQLI_ASSOC);

        $salt = $row['salt'];
        $hasedPasswd = hash("sha256", $salt . $passwd);

        if ($hasedPasswd == $row['passwd']) {
            $_SESSION['user'] = $user;
            header("Location: home.php");
        } else {
            $wrongPasswd = true;
        }

    }

}

?>

<html>

<head>
    <title>BooksReviews - login</title>

    <link rel="stylesheet" href="https://bootswatch.com/_vendor/bootstrap/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body>

    <div class="container">

        <div class="row">

            <div class="col-lg-6 offset-lg-3 offset-md-2 col-md-8 col-sm-12">

                <br><br><br>

                <h1>Effettua il login</h1>

                <hr class="black">

                <form method="post" id="loginForm">

                    <div class="fieldset">

                        <div class="form-group has-danger">
                            <label for="user" class="form-control-label">Username</label>
                            <input class="form-control <?php if(isset($usernameNotFound) && $usernameNotFound) echo "is-invalid"; ?>" type="text" name="user" id="user" value="<?php if(isset($user)) echo $user; ?>">
                            <div class="invalid-feedback" id="userError"><?php if(isset($usernameNotFound)) if($usernameNotFound) echo "Username non valido"; ?></div>
                        </div>
                        <div class="form-group has-danger">
                            <label for="passwd" class="form-control-label">Password</label>
                            <input class="form-control <?php if(isset($wrongPasswd) && $wrongPasswd) echo "is-invalid"; ?>" type="password" name="passwd" id="passwd">
                            <div class="invalid-feedback" id="passwdError"><?php if(isset($wrongPasswd)) if($wrongPasswd) echo "Password errata"; ?></div>
                        </div>
                        <div class="form-group">
                            Non hai un account? <a href="createAccount.php">registrati</a>!
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="button" onclick="formValidation()">Entra</button>
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

        $("#user").focusout( function () { requiredItem("user") } );
        $("#passwd").focusout( function () { requiredItem("passwd") } );

        function formValidation () {
            if(requiredItem("user") && requiredItem("passwd") )
                $("#loginForm").submit();
        }

        $("#loginForm").keypress(function (event) {
            if (event.which == 13 || event.keyCode == 13) {
                formValidation();
                return false;
            }
            return true;
        });

    </script>

</body>

</html>

