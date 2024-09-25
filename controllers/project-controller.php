<?php
require_once('models/project-model.php');

class ProjectController {

    private $service;

    function __construct() {
        $this -> service = require 'services/project-service.php';
        $this -> project = new Project();
    }

    public function getProjects() {
        $projects = $this -> service -> getAllProjects();
        return $projects;
    }

    public function createProject($project) {
        $project = new Project(
            $projectData['id'],
            $projectData['project_name'],
            $projectData['project_priority'],
            $projectData['project_status'],
            $projectData['created_at'],
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