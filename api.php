<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 11/02/18
 * Time: 10.18
 */

include_once "connessione.php";
include_once "checkLogin.php";

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

        case "isbnExists":

            checkLogin($conn);

            if (isset($_GET['isbn']))
                $isbn = $_GET['isbn'];
            else
                die("Parametro isbn mancante");

            $prep = $conn->prepare("SELECT * FROM libri WHERE isbn = ?;");
            $prep->bind_param('s', $isbn);
            $prep->execute();
            $ris = $prep->get_result();

            if ($ris->num_rows != 0)
                $arr = array('request' => $req, 'response' => true);
            else
                $arr = array('request' => $req, 'response' => false);

            echo json_encode($arr);

            break;

        case "getLibri":

            checkLogin($conn);

            $query = "SELECT l.isbn, titolo, autore, annoUscita, genere, AVG(r.voto) AS votoMedio FROM libri l LEFT OUTER JOIN recensioni r ON l.isbn = r.isbn";
            $groupBy = " GROUP BY l.isbn";

            if(isset($_GET['searchStr'])){

                $searchStr = $conn->real_escape_string($_GET['searchStr']); //SQL INJECTIONS!!!!!!!
                $query.=" WHERE l.isbn LIKE '%".$searchStr."%' OR titolo LIKE '%".$searchStr."%' OR autore LIKE '%".$searchStr."%' OR annoUscita LIKE '%".$searchStr."%' OR genere LIKE '%".$searchStr."%'";

            }

            $query .= $groupBy;

            if(isset($_GET['orderBy'])){
                $orderBy = $_GET['orderBy'];
                $query.=" ORDER BY ".$orderBy;

                if(isset($_GET['asc'])){
                    $asc = $_GET['asc'];
                    if($asc == 'true'){
                        $query.=" ASC";
                    } else {
                        $query.=" DESC";
                    }
                }
            }

            $ris = $conn->query($query);

            if($ris->num_rows == 0){
                $arr = array('request' => $req, 'response' => 'noElements');
            } else {
                $books = array();
                while ($row = $ris->fetch_array(MYSQLI_NUM)){
                    array_push($books, $row);
                }
                $arr = array('request' => $req, 'length' => $ris->num_rows , 'response' => $books);
            }

            echo json_encode($arr);

            break;

        default:
            die("Richiesta errata");
            break;

    }

} else {
    die("Richiesta errata");
}