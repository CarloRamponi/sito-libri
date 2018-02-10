<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 26/01/18
 * Time: 14.14
 */

    $conn = new mysqli("localhost", "sito-libri", "libriPasswd", "sito-libri");

    if($conn->error){
        die("Errore nella connessione n. ".$conn->errno);
    }

?>