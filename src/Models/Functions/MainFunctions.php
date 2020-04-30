<?php

require '../src/Models/Functions/DatabaseFunctions.php';

function dd(...$vars) :void {
    foreach($vars as $var){
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}