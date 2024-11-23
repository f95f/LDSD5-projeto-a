<?php

class Project {
    private $id;
    private $project_name;
    private $project_priority;
    private $project_status;
    private $project_description;
    private $start_date;
    private $created_at;
    private $deadline;

    public function __construct(
        $id, 
        $project_name, 
        $project_priority, 
        $project_status, 
        $project_description,
        $start_date,
        $created_at, 
        $deadline
        ) {
        $this->id = $id;
        $this->project_name = $project_name;
        $this->project_priority = $project_priority;
        $this->project_description = $project_description;
        $this->start_date = $start_date;
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

    public function getDescription() {
        return $this->project_description;
    }

    public function setDescription($project_description) {
        $this->project_description = $project_description;
    }

    public function getStartDate() {
        return $this->start_date;
    }

    public function setStartDate($start_date) {
        $this->start_date = $start_date;
    }
}