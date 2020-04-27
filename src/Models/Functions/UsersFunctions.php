<?php


function login(){
    var_dump(tableExist('users'));
    die;
    $_SESSION = $user;
}