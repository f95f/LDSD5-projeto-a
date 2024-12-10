import { fireError, fireSuccess } from './toast.js';
import { validateForm } from './validation.js';

$(document).ready(function () {

    $('#addTaskForm').hide();

    $('#addTaskForm').submit(function(event) {
        event.preventDefault();


        const fieldsToValidate = [
            { selector: '#taskDescription', errorMessage: 'Descrição da task é obrigatória.', validationFn: (value) => !!value },
            { selector: '#deadline', errorMessage: 'Deadline da task é obrigatória.', validationFn: (value) => !!value && !isNaN(Date.parse(value)) }
        ];

        if (!validateForm(fieldsToValidate)) {

            fireError("Preencha todos os campos.");
            return;
        }

        
    
        var formData = $(this).serialize();

        $.ajax({
            url: '',
            type: 'POST',
            data: `${formData}&action=ADD_TASK`,
            success: function(response) {
                location.reload();
                fireSuccess("Task criada.");
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
                // location.reload();
                fireSuccess("Task exluída com sucesso.");
                $(this).closest('.task-card').remove();
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