<?php
require_once  __DIR__  . '/../services/calendario-service.php';

class CalendarioController {

    private $service;

    function __construct() {
        $this->service = new CalendarioService();
    }


    public function getAllProjectsPerMonth($startDate, $endDate) {

        $items = $this->service->getAllProjects($startDate, $endDate);
        return $items;
    }


    public function getAllTasksPerMonth($startDate, $endDate) {


        $items = $this->service->getAllTasks($startDate, $endDate);

        $filteredItems = array_filter($items, function($value) {
            return $value['project_id'] == 0;
        });
    
        
        $filteredItems = array_values($filteredItems);
    
        return $filteredItems;
    }
}