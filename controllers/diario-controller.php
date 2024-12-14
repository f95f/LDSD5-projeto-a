<?php
require_once  __DIR__  . '/../services/diario-service.php';

class DiarioController{

    private $service;

    function __construct() {
        $this->service = new DiarioService();
    }

    public function getAllDiarios() {
        $diarios = $this -> service -> getAllDiarios();
        return $diarios;
    }

    public function searchDiarios($query) {
        $value = $query['searchInput'];
        $diarios = $this -> service -> searchDiarios($value);

        return $diarios;
    }


    public function createDiario($diarioData) {
        $this->service->createDiario($diarioData);
    }

    public function updateDiario($diarioData) {
        
        $this -> service -> updateDiario($diarioData);
    }

    public function deleteDiario($diarioId) {
        print_r($diarioId);
        if($diarioId) {
            $this -> service -> deleteDiario($diarioId);
        }
    }
}