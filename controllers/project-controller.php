<?php
require_once  __DIR__  . '/../services/project-service.php';
require_once  __DIR__  . '/../services/status-service.php';
require_once  __DIR__  . '/../services/priority-service.php';
require_once  __DIR__  . '/../models/project-model.php';

class ProjectController {

    private $service;
    private $statusService;
    private $priorityService;

    function __construct() {

        $this->service = new ProjectService();
        $this->statusService = new StatusService();
        $this->priorityService = new priorityService();
    }


    public function getAllProjects() {
        $projects = $this -> service -> getAllProjects();
        $status = $this->statusService->getAllStatus();
        $priorities = $this->priorityService->getAllPriorities();

        if(!is_array($status) || empty($status) || !is_array($priorities) || empty($priorities) ) {
            return $projects;
        }

        if(is_array($projects) && !empty($projects)) {
            
            $projectList = [];
            
            foreach($projects as $item) {
                
                $item['project_status'] = $this->getStatus($item['project_status'], $status);
                $item['project_priority'] = $this->getPriority($item['project_priority'], $priorities);
                $projectList[] = $item;

            }
            
            return $projectList;
        }

        return $projects;
    }

    

    public function searchProjects($query) {
        $value = $query['searchInput'];
        $projects = $this -> service -> searchProjects($value);

        $status = $this->statusService->getAllStatus();
        $priorities = $this->priorityService->getAllPriorities();

        if(!is_array($status) || empty($status) || !is_array($priorities) || empty($priorities) ) {
            return $projects;
        }

        if(is_array($projects) && !empty($projects)) {
            
            $projectList = [];
            
            foreach($projects as $item) {
                
                $item['project_status'] = $this->getStatus($item['project_status'], $status);
                $item['project_priority'] = $this->getPriority($item['project_priority'], $priorities);
                $projectList[] = $item;
                
            }
            
            return $projectList;
        }

        return $projects;
    }

    public function getProjectById($projectId) {
        $project = $this -> service -> getProjectById($projectId);
        $status = $this->statusService->getAllStatus();
        $priorities = $this->priorityService->getAllPriorities();

        if(!is_array($status) || empty($status) || !is_array($priorities) || empty($priorities) ) {
            return $project;
        }
        
        $project[0]['project_status'] = $this->getStatus($project[0]['project_status'], $status);
        $project[0]['project_priority'] = $this->getPriority($project[0]['project_priority'], $priorities);

        
        return $project;
    }

    public function createProject($projectData) {
        $project = new Project(
            0,
            $projectData['projectName'],
            $projectData['projectPriority'],
            0,
            date("Y-m-d"),
            $projectData['deadline']
        );
        $this->service->createProject($project);
    }

    public function updateProject($projectId, $projectDescription) {
        $project = new Project(
            $projectData['id'],
            $projectData['project_name'],
            $projectData['project_priority'],
            $projectData['project_status'],
            $projectData['created_at'],
            $projectData['deadline']
        );
        $this -> service -> updateProject($project);
    }

    public function deleteProject($projectId) {
        if($projectId) {
            $this -> service -> deleteProject($projectId);
        }
    }

    public function changeProjectStatus($projectId, $status) {
        if($projectId && $status) {
            $this -> service -> changeProjectStatus($projectId, $status);
        }
    }


    private function getStatus($id, $status) {
        $filtered = array_filter($status, function($item) use ($id) {
            return $item['id'] == $id;
        });
        return !empty($filtered) ? array_values($filtered)[0]['status'] : 'Desconhecido';
    }

    private function getPriority($id, $priorities) {
        $filtered = array_filter($priorities, function($item) use ($id) {
            return $item['id'] == $id;
        });

        return !empty($filtered)? array_values($filtered)[0]['priority'] : 'Desconhecida'; 
    }
}