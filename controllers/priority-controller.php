<?php

class PriorityController {

    private $service;

    function __construct() {
        $this -> service = require 'services/status-service.php';
        $this -> project = new Project();
    }

    public function getPriority() {
        $priority = $this -> service -> getAllPriority();
        return $priority;
    }
}