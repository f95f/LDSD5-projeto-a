<?php
require_once 'services/priority-service.php';

class PriorityController {

    private $service;

    function __construct() {
        $this -> service = new PriorityService();
    }

    public function getAllPriorities() {
        $priority = $this -> service -> getAllPriorities();
        return $priority;
    }
}