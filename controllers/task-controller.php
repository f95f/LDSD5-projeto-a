<?php
require_once  __DIR__  . '/../services/task-service.php';
require_once  __DIR__  . '/../services/status-service.php';
require_once  __DIR__  . '/../services/priority-service.php';
require_once  __DIR__  . '/../models/task-model.php';

class TaskController{

    private $service;
    private $statusService;
    private $priorityService;

    function __construct() {
        $this -> service = new TaskService();
        $this->priorityService = new priorityService();
    }

    public function getTasks() {
        $tasks = $this -> service -> getAllTasks();
        $priorities = $this->priorityService->getAllPriorities();

        if(!is_array($priorities) || empty($priorities) ) {
            return $tasks;
        }

        if(is_array($tasks) && !empty($tasks)) {
            
            $taskList = [];
            
            foreach($tasks as $item) {
                
                $item['task_priority'] = $this->getPriority($item['task_priority'], $priorities);
                $taskList[] = $item;

            }
            
            return $taskList;
        }
        return $tasks;
    }

    public function createTask($taskData) {
        $projectId = $taskData['projectId']? $taskData['projectId'] : 0;
        $task = new Task(
            0,
            $taskData['taskDescription'],
            $taskData['taskPriority'],
            0,
            $projectId,
            date("Y-m-d"),
            $taskData['deadline']
        );
        $this -> service -> createTask($task);
    }

    public function updateTask($id, $taskData) {
        $task = new Task(
            $id,
            $taskData['description'],
            $taskData['taskPriority'],
            0,
            $taskData['projectId'],
            $taskData['startDate'],
            $taskData['deadline']
        );
        $this -> service -> updateTask($id, $task);
    }

    public function deleteTask($taskId) {
        if($taskId) {
            $this -> service -> deleteTask($taskId);
        }
    }

    public function getTasksFromProject($projectId) {
        if(!$projectId) {
            return;
        }

        $tasks = $this->service->getTasksFromProject($projectId);
        $priorities = $this->priorityService->getAllPriorities();

        if(!is_array($priorities) || empty($priorities) ) {
            return $tasks;
        }

        if(is_array($tasks) && !empty($tasks)) {
            
            $taskList = [];
            
            foreach($tasks as $item) {
                
                $item['task_priority'] = $this->getPriority($item['task_priority'], $priorities);
                $taskList[] = $item;

            }
            
            return $taskList;
        }

        return $tasks;
    }

    
    public function filterByStatus($status) {
        if(!$status) {
            return;
        }

        $tasks = $this->service->filterTasksByStatus($status);
        $priorities = $this->priorityService->getAllPriorities();
        
        if(!is_array($priorities) || empty($priorities) ) {
            return $tasks;
        }

        if(is_array($tasks) && !empty($tasks)) {
            
            $taskList = [];
            
            foreach($tasks as $item) {
                
                $item['task_priority'] = $this->getPriority($item['task_priority'], $priorities);
                $taskList[] = $item;

            }
            
            return $taskList;
        }

        return $tasks;
    }

    public function changeStatus($taskId, $status) {
        $formattedStatus = $status? 1 : 0;
        return $this->service->changeTaskStatus($taskId, $formattedStatus);
    }

    private function getPriority($id, $priorities) {
        $filtered = array_filter($priorities, function($item) use ($id) {
            return $item['id'] == $id;
        });

        return !empty($filtered)? array_values($filtered)[0]['priority'] : 'Desconhecida'; 
    }
}