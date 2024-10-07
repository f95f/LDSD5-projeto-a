<?php 

class Task {
    private $id;
    private $task_description;
    private $task_priority;
    private $task_completed;
    private $project_id;
    private $created_at;
    private $deadline;

    public function __construct($id, $task_description, $task_priority, $task_completed, $project_id, $created_at, $deadline) {
        $this->id = $id;
        $this->task_description = $task_description;
        $this->task_priority = $task_priority;
        $this->task_completed = $task_completed;
        $this->project_id = $project_id;
        $this->created_at = $created_at;
        $this->deadline = $deadline;
    }

    public function getId() {
        return $this->id;
    }

    public function getTaskDescription() {
        return $this->task_description;
    }

    public function getTaskPriority() {
        return $this->task_priority;
    }

    public function isTaskCompleted() {
        return $this->task_completed;
    }

    public function getProjectId() {
        return $this->project_id;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getDeadline() {
        return $this->deadline;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTaskDescription($task_description) {
        $this->task_description = $task_description;
    }

    public function setTaskPriority($task_priority) {
        $this->task_priority = $task_priority;
    }

    public function setTaskCompleted($task_completed) {
        $this->task_completed = $task_completed;
    }

    public function setProjectId($project_id) {
        $this->project_id = $project_id;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function setDeadline($deadline) {
        $this->deadline = $deadline;
    }

}

?>