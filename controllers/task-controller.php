<?php

class TaskController{

    private $service;

    function __construct() {
        $this -> service = require 'services/task-service.php';
    }

    public function getTasks() {
        $tasks = $this -> service -> getAllTasks();
        return $tasks;
    }

    public function createTask($taskDescription) {
        if($taskDescription) {
            $this -> service -> createTask($taskDescription);
        }
    }
}