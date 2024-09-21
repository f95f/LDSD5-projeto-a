$(document).ready(function () {
    
    $('#addTaskForm').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission
    
        var taskDescription = $('#taskDescription').val();
    
        $.ajax({
            url: '',
            type: 'POST',
            data: {
                taskDescription: taskDescription
            },
            success: function(response) {
                location.reload();
                $('#taskDescription').val('');
            },
            error: function(xhr, status, error) {
                console.error('Error adding task:', error);
            }
        });
    });

    $('.edit-button').on('click', function () {
        var task = $(this).closest('.task');
        task.find('.progress').addClass('hidden');
        task.find('.task-description').addClass('hidden');
        task.find('.task-actions').addClass('hidden');
        task.find('.edit-task').removeClass('hidden');
    });

    $('.edit-task').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission
    
        var form = $(this);
        var taskId = form.find('input[name="id"]').val();
        var taskDescription = form.find('input[name="description"]').val();
        $.ajax({
            url: '',
            type: 'PUT',
            data: {
                id: taskId,
                description: taskDescription
            },
            success: function(response) {
                // if (response.success) {
                    var task = form.closest('.task');
                    task.find('.task-description').text(taskDescription);
                    task.find('.edit-task').addClass('hidden'); // Hide the edit form
                    task.find('.progress').removeClass('hidden'); // Show the checkbox
                    task.find('.task-description').removeClass('hidden'); // Show the description
                    task.find('.task-actions').removeClass('hidden'); // Show the actions

                    location.reload();
                // }
            },
            error: function(xhr, status, error) {
                console.error('Error updating task:', error);
            }
        });
    });
    
    $('.delete-button').click(function(event) {
        event.preventDefault();
    
        var taskId = $(this).closest('.task').find('.progress').data('task-id');
    
        $.ajax({
            url: '',
            type: 'DELETE',
            data: {
                id: taskId
            },
            success: function(response) {
                // if (response.success) { alert(1)
                    $(this).closest('.task').remove();
                    location.reload();
                // }
            }.bind(this), // Bind 'this' to access the delete button
            error: function(xhr, status, error) {
                console.error('Error deleting task:', error);
            }
        });
    });

    // $('.progress').on('click', function () {
    //     if ($(this).is(':checked')) {
    //         $(this).addClass('done');
    //     } else {
    //         $(this).removeClass('done');
    //     }
    // });

    // $('.progress').on('change', function () {
    //     const id = $(this).data('task-id');
    //     const completed = $(this).is(':checked') ? 'true' : 'false';
    //     $.ajax({
    //         url: '../controllers/update-progress.php',
    //         method: 'POST',
    //         data: {id: id, completed: completed},
    //         dataType: 'json',
    //         success: function (response) {
    //             if (response.success) {

    //             } else {
    //                 alert('Erro ao editar a tarefa');
    //             }
    //         },
    //         error: function () {
    //             alert('Ocorreu um erro');
    //         }
    //     });
    // })
});