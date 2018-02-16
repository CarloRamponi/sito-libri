<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 10/02/18
 * Time: 23.09
 */


//il parametro index serve a dire alla funzione se deve reindirizzare l'utente alla pagina di login nel
//caso in cui non sia loggato (non deve farlo se la funzione è eseguita dalla pagina di login stessa)
function checkLogin($conn, $index = false)
{

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['user'])) {

        $user = $_SESSION['user'];

        $prep = $conn->prepare("SELECT * FROM users WHERE username = ?;");
        $prep->bind_param('s', $user);
        $prep->execute();
        $ris = $prep->get_result();

        if ($ris->num_rows != 0) {
            if($index)
                header("Location: libri.php");
            return $user;
        }
        else {
            unset($_SESSION['user']);
            unset($_SESSION['id_utente']);
            header("Location: index.php");
        }

    } else {
        if(!$index)
            header("Location: index.php");
    }

}