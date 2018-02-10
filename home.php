<?php
/**
 * Created by PhpStorm.
 * User: carlo
 * Date: 10/02/18
 * Time: 23.09
 */

include_once "connessione.php";
include_once "checkLogin.php";

$user = checkLogin($conn);

echo "Ciao!  ".$user;