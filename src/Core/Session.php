<?php

namespace App\Core;

class Session{

    public function __construct(){
        session_start();
    }

    public function setFlash(string $type, string $message){
        $_SESSION['flash'] = array(
            'type' => $type,
            'message' => $message
        );
    }

    public function flash() :array {
        $flash = array();

        if (isset($_SESSION['flash'])) {

            $flash = $_SESSION['flash'];

            unset($_SESSION['flash']);
        }

        return $flash;
    }
}