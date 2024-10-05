<?php

class DiarioController{

    private $service;

    function __construct() {
        $this -> service = require 'services/task-service.php';
    }
}