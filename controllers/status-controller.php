<?php
require_once 'services/status-service.php';

class StatusController {

    private $service;

    function __construct() {
        $this -> service = new StatusService();
    }

    public function getAllStatus() {
        $status = $this -> service -> getAllStatus();
        return $status;
    }
}