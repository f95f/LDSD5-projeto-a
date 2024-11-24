<?php
require_once  __DIR__  . '/../services/usuario-service.php';

class UsuarioController{

    private $service;

    function __construct() {
        $this -> service = new UsuarioService();
    }
}