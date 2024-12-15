import { fireError, fireSuccess } from './toast.js';
import { validateForm } from './validation.js';

$(document).ready(function () {

    $('#addProjectTaskForm').hide();
    $('#editProjectModal').hide();



    $(document).on('click', '#showFormModal', function() {
        $('#editProjectModal').fadeIn();
        $('.overlay').fadeIn();


    });
    
    $(document).on('click', '#closeEditProjectModal', function() {
        $('#editProjectModal').fadeOut();
        $('.overlay').fadeOut();
    });
    
    $(document).on('click', '.overlay', function() {
        $('#editProjectModal').fadeOut();
        $('.overlay').fadeOut();
    });

    $('#addProjectTaskForm').submit(function(event) {
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


    $('#addProjectForm').submit(function(event) {
        event.preventDefault();


        const fieldsToValidate = [
            { selector: '#projectName', errorMessage: 'O nome do projeto é obrigatório.', validationFn: (value) => !!value },
            { selector: '#projectDescription', errorMessage: 'A descrição do projeto é obrigatório.', validationFn: (value) => !!value },
            { selector: '#startDate', errorMessage: 'Data de início é obrigatória.', validationFn: (value) => !!value && !isNaN(Date.parse(value)) },
        ];

        if (!validateForm(fieldsToValidate)) {

            fireError("Preencha todos os campos.");
            return;
        }



        var formData = $(this).serialize();

        $.ajax({
            url: '',
            type: 'POST',
            data: `${formData}&action=UPDATE_PROJECT`,
            success: function(response) {
                location.reload();
                fireSuccess("Projeto Atualizado.");
            },
            error: function(xhr, status, error) {
                console.error('Error updating project:', error);
            }
        });
    });


    $('#toggleTaskButton').click(function() {
        $('#addProjectTaskForm').toggle();
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


    $(document).on('click', '#deleteProjectButton', function() {
        $.ajax({
            url: '',
            type: 'POST',
            data: {
                action: 'DELETE_PROJECT',
            },
            success: function(response) {
                location.href = 'projects.php';
            },
            error: function(xhr, status, error) {
                console.error('Error deleting project:', error);
            }
        });
    });
    
});