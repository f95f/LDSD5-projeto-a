<?php
require_once  __DIR__  . '/../services/usuario-service.php';

class UsuarioController{

    private $service;

    function __construct() {
        $this -> service = new UsuarioService();
    }

    function getDeadlinePreferences() {
        $id = $_SESSION['id'];
        return $this->service->getDeadlinePreferences($id);
    }


    function setDeadlinePreferences($daysBeforeDeadline) {
        $id = $_SESSION['id'];
        return $this->service->setDeadlinePreferences($id, $daysBeforeDeadline);
    }
}