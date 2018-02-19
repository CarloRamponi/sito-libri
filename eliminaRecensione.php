<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 19/02/18
 * Time: 14.51
 */

include_once "connessione.php";
include_once "checkLogin.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user = checkLogin($conn);

if(isset($_GET['isbn']) && ($isbn = $_GET['isbn']) != ""){

    $utente = $_SESSION['id_utente'];

    $prep = $conn->prepare("DELETE FROM recensioni WHERE isbn=? AND id_utente=?");
    $prep->bind_param('ss', $isbn, $utente);
    $prep->execute();
    $ris = $prep->get_result();

    if($ris == 0){
        header("Location: libro.php?isbn=".$isbn);
    } else {
        die("Errore");
    }

}

?>