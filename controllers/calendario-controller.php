<?php
require_once  __DIR__  . '/../services/calendario-service.php';

class CalendarioController {

    private $service;

    function __construct() {
        $this->service = new CalendarioService();
    }


    public function getAllProjectsPerMonth($startDate, $endDate) {
        
        
        $endDate = $endDate . ' 23:59:59';

        $items = $this->service->getAllProjects($startDate, $endDate);
        return $items;
    }


    public function getAllTasksPerMonth($startDate, $endDate) {

        // $endDate = $endDate . ' 23:59:59';

        $items = $this->service->getAllTasks($startDate, $endDate);
        //TODO: filtrar fora tasks com projetos, retornar apenas avulsas
        return $items;
    }
}