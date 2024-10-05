<?php

class PerfilController{

    private $service;

    function __construct() {
        $this -> service = require 'services/task-service.php';
    }
}