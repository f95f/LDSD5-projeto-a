$(document).ready(function() {
    $('edit-button').on('click', function() {
        let $task = $(this).closest('.task');

        $task.find('.progress').addClasss('hidden');
        $task.find('.task-description').addClasss('hidden');
        $task.find('.task-action').addClasss('hidden');
        $task.find('.edit-task').removeClasss('hidden');
    });
});