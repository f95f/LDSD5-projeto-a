<?php
require_once  __DIR__  . '/../services/task-service.php';
require_once  __DIR__  . '/../models/task-model.php';

class TaskController{

    private $service;

    function __construct() {
        $this -> service = new TaskService();
    }

    public function getTasks() {
        $tasks = $this -> service -> getAllTasks();
        return $tasks;
    }

    public function createTask($taskData) {
        $task = new Task(
            0,
            $taskData['taskDescription'],
            $taskData['taskPriority'],
            0,
            $taskData['projectId'],
            date("Y-m-d"),
            $taskData['deadline']
        );
        $this -> service -> createTask($task);
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

    public function getTasksFromProject($projectId) {
        if($projectId) {
            return $this->service->getTasksFromProject($projectId);
        }
    }
}