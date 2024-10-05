<?php

class UsuarioController{

    private $service;

    function __construct() {
        $this -> service = require 'services/task-service.php';
    }
}