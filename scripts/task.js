import { fireError, fireSuccess } from './toast.js';
import { validateForm } from './validation.js';

$(document).ready(function () {
    
    $('#addTaskForm').submit(function(event) {
        event.preventDefault();


        const fieldsToValidate = [
            { selector: '#taskDescription', errorMessage: 'Task name is required.', validationFn: (value) => !!value },
            { selector: '#deadline', errorMessage: 'Due date is required.', validationFn: (value) => !!value && !isNaN(Date.parse(value)) }
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
    
    $('.edit-button').on('click', function () {
        var task = $(this).closest('.task');
        task.find('.progress').addClass('hidden');
        task.find('.task-description').addClass('hidden');
        task.find('.task-actions').addClass('hidden');
        task.find('.edit-task').removeClass('hidden');
    });

    $('.edit-task').submit(function(event) {
        event.preventDefault();
    
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
    
    

    $('.priority-filter-button').on('click', function(event){
        const status = $(this).data('status');
        
        $.ajax({
            url: '',
            type: 'POST',
            data: {
                action: 'FILTER_STATUS',
                status: status
            },
            success: function(response) {

                if (typeof response === 'string') {
                    response = JSON.parse(response);
                }
                
                if (response.success) {
                    $('#taskList').empty();

                    if(!response.content.length) {
                        let emptyListMessage = makeEmptyListMessage(); 
                        $('#taskList').append(emptyListMessage());
                    }

                    response.content.forEach(function(task) {
                        let card = makeCard(task);
                        $('#taskList').append(card);
                    });
                } else {
                    let emptyListMessage = makeEmptyListMessage(); 
                    $('#taskList').append(emptyListMessage);
                    console.error('Search not successful: ', response.content);
                }

            },
            error: function(xhr, status, error) {
                console.error('Error fetching tasks:', error);
            }
        });
    });


    $('#clearFilters').click(function() {
        location.reload();
    });


    $('#selectProject').on('change', function(event) {

        var projectId = event.target.value;
    
        $.ajax({
            url: '',
            type: 'POST',
            data: `projectId=${projectId}&action=FILTER_PROJECT`,
            success: function(response) {

                if (typeof response === 'string') {
                    response = JSON.parse(response);
                }

                console.warn(response)
                if (response.success) {
                    $('#taskList').empty();

                    if(!response.content.length) {
                        let emptyListMessage = makeEmptyListMessage(); 
                        $('#taskList').append(emptyListMessage);
                    }

                    response.content.forEach(function(task) {
                        let card = makeCard(task);
                        $('#taskList').append(card);
                    });

                } else {
                    console.error('Search not successful: ', response.content);
                }

            }.bind(this),
            error: function(xhr, status, error) {
                console.error('Error filtering task:', error);
            }
        });
    });


    $('.deleteTaskButton').click(function(event) {
        event.preventDefault();
    
        var taskId = $(this).data('task-id');
    
        $.ajax({
            url: '',
            type: 'POST',
            data: `taskId=${taskId}&action=DELETE_TASK`,
            success: function(response) {
                fireSuccess("Task exluída com sucesso.");

                $(this).closest('.task-card').remove();
            }.bind(this),
            error: function(xhr, status, error) {
                console.error('Error deleting task:', error);
            }
        });
    });

    $('#taskList').on('change', 'form#completeForm input[name="completed"]', function() {
        var taskId = $(this).closest('form').find('.taskId').val();
        var completed = $(this).is(':checked') ? 1 : 0;
        
        $.ajax({
            type: 'POST',
            url: '',
            data: `action=change-status&taskId=${taskId}&completed=${completed}`,
            success: function(data) {
                console.info('Form submitted successfully', data);
            }
        });
    });
    
    

});

let makeEmptyListMessage = function() {
    return `
        <span class="light-text large">
            Nenhuma task encontrada...
        </span>
    `
}

let makeCard = function(item) {
    let status = '';
    let icon = '';

    switch(item.task_priority) {
        case 'MEDIA':
            status = 'success';
            icon = 'fa-circle-minus';
            break;
        case 'ALTA':
            status = 'warning';
            icon = 'fa-circle-info';
            break;
        case 'CRITICA':
            status = 'danger';
            icon = 'fa-circle-exclamation';
            break;
        default:
            status = ''
            icon = 'fa-circle';
    }

    return `

    <div class="task-card">
        <div class="left-card-wrapper">
            <i class="fa-solid fa-list-check light-text"></i>
            <span class="light-text">|</span>

            <i class="fa-solid light-text status
            ${status} ${icon}
            "></i>

            <span>${item.task_description}</span>
        </div>
        <div class="right-card-wrapper">
            
            <span class="light-text">até</span>
            <span>${item.deadline}</span>
            <span class="light-text">|</span>



            <form method="POST" id="completeForm" name="completeForm">
                <label class="switch" for="${item.id}">
                    <input 
                        type="checkbox"
                        class="completed"
                        id="${item.id}"
                        ${item.task_completed? 'checked' : ''}
                        name="completed">
                    <span class="slider round"></span>
                </label>
                Concluída
                <input type="hidden" class="taskId" name="taskId" value="${item.id}"">
            </form>




            <span class="light-text">|</span>

            <i class="fa-solid fa-edit light-text"></i>
            <a  role="button"
                class="inline-button deleteTaskButton"
                data-task-id="${item.id}">
                <i class="fa-solid fa-trash light-text"></i>
            </a>
        </div>
    </div>

    `
}

// function validateForm(fields) {
//     let isValid = true;
//     $('.error-message').remove();

//     fields.forEach(({ selector, errorMessage, validationFn }) => {
//         const value = $(selector).val().trim();
//         if (!validationFn(value)) {
//             $(selector).before(`<span class="error-message">${errorMessage}</span>`);
//             isValid = false;
//         }
//     });

//     return isValid;
// }