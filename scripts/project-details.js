$(document).ready(function () {

    $('#addTaskForm').hide();

    $('#addTaskForm').submit(function(event) {
        event.preventDefault();
    
        var formData = $(this).serialize();

        $.ajax({
            url: '',
            type: 'POST',
            data: `${formData}&action=ADD_TASK`,
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error adding task:', error);
            }
        });
    });

    $('#toggleTaskButton').click(function() {
        $('#addTaskForm').toggle();
    });

    
    $('.deleteTaskButton').click(function() {
        var taskId = $(this).data('task-id');
        $.ajax({
            url: '',
            type: 'POST',
            data: {
                id: taskId,
                action: 'DELETE_TASK',
            },
            success: function(response) {
                location.reload();
                if (response.success) {
                    console.log('Received data:', response.received_data);
                    
                }
            }.bind(this),
            error: function(xhr, status, error) {
                console.error('Error deleting task:', error);
            }
        });
    });    

    $('.deleteProjectButton').click(function() {
        $.ajax({
            url: '',
            type: 'POST',
            data: {
                action: 'DELETE_PROJECT',
            },
            success: function(response) {
                location.href = 'projects.php';
                if (response.success) {
                    console.log('Received data:', response.received_data);
                    
                }
            }.bind(this),
            error: function(xhr, status, error) {
                console.error('Error deleting project:', error);
            }
        });
    });
});