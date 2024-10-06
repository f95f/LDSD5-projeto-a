<?php
require_once __DIR__  . '/../services/status-service.php';

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