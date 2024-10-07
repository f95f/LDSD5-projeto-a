<?php

class Project {
    private $id;
    private $project_name;
    private $project_priority;
    private $project_status;
    private $created_at;
    private $deadline;

    public function __construct($id, $project_name, $project_priority, $project_status, $created_at, $deadline) {
        $this->id = $id;
        $this->project_name = $project_name;
        $this->project_priority = $project_priority;
        $this->project_status = $project_status;
        $this->created_at = $created_at;
        $this->deadline = $deadline;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getProjectName() {
        return $this->project_name;
    }

    public function setProjectName($project_name) {
        $this->project_name = $project_name;
    }

    public function getProjectPriority() {
        return $this->project_priority;
    }

    public function setProjectPriority($project_priority) {
        $this->project_priority = $project_priority;
    }

    public function getProjectStatus() {
        return $this->project_status;
    }

    public function setProjectStatus($project_status) {
        $this->project_status = $project_status;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getDeadline() {
        return $this->deadline;
    }

    public function setDeadline($deadline) {
        $this->deadline = $deadline;
    }
}