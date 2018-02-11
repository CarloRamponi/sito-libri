<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 11/02/18
 * Time: 10.18
 */

include_once "connessione.php";

if(isset($_GET['req'])) {

    $req = $_GET['req'];

    switch ($req) {
        case "usernameExists":
            if (isset($_GET['user']))
                $user = $_GET['user'];
            else
                die("Parametro user mancante");

            $prep = $conn->prepare("SELECT * FROM users WHERE username = ?;");
            $prep->bind_param('s', $user);
            $prep->execute();
            $ris = $prep->get_result();

            if ($ris->num_rows != 0)
                $arr = array('request' => $req, 'response' => true);
            else
                $arr = array('request' => $req, 'response' => false);

            echo json_encode($arr);

            break;

        default:
            die("Richiesta errata");

    }

} else {
    die("Richiesta errata");
}