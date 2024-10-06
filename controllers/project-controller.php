<?php
require_once 'services/project-service.php';
require_once 'models/project-model.php';

class ProjectController {

    private $service;

    function __construct() {
        // $this -> service = require 'services/project-service.php';

        $this->service = new ProjectService();
    }

    public function getAllProjects() {
        $projects = $this -> service -> getAllProjects();
        return $projects;
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
}