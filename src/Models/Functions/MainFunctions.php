<?php

require '../src/Models/Functions/DatabaseFunctions.php';

function dd(...$vars) :void {
    foreach($vars as $var){
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}

function loggedOnly() :void {
    if (!isset($_SESSION['auth'])) {
        header('Location: 404.html');
        die;
    }
}