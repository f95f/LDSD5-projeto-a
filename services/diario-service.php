<?php

require_once('database/conn.php');

class DiarioService {
    private $sql;
    private $pdo;
    
    function __construct() {
        $this->pdo = require 'database/conn.php';
    }
}

return new DiarioService();