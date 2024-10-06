<?php

class TaskController{

    private $service;

    function __construct() {
        $this -> service = require '../services/task-service.php';
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

    public function updateTask($taskId, $taskDescription) {
        if($taskDescription) {
            $this -> service -> updateTask($taskId, $taskDescription);
        }
    }

    public function deleteTask($taskId) {
        if($taskId) {
            $this -> service -> deleteTask($taskId);
        }
    }

    public function changeTaskStatus($taskId) {
        if($taskId) {
            $this -> service -> changeTaskStatus($taskId);
        }
    }
}