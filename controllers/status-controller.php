<?php

class StatusController {

    private $service;

    function __construct() {
        $this -> service = require 'services/status-service.php';
        $this -> project = new Project();
    }

    public function getStatus() {
        $status = $this -> service -> getAllStatus();
        return $status;
    }
}