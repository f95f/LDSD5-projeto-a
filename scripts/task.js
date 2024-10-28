import { fireError, fireSuccess } from './toast.js';


$(document).ready(function () {
    
    $('#addTaskForm').submit(function(event) {
        event.preventDefault();
    
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
                console.warn(response)
                if (response.success) {
                    $('#taskList').empty();
                    response.content.forEach(function(task) {
                        let card = makeCard(task);
                        $('#taskList').append(card);
                    });
                } else {
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

    $('.progress').on('click', function () {
        if ($(this).is(':checked')) {
            $(this).addClass('done');
        } else {
            $(this).removeClass('done');
        }
    });

    $('.progress').on('change', function () {

        var taskId = $(this).closest('.task').find('.progress').data('task-id');
        const completed = $(this).is(':checked') ? 'true' : 'false';
    
        $.ajax({
            url: '',
            type: 'PUT',
            data: {
                id: taskId,
                completed: completed
            },
            success: function(response) {
                // if (response.success) { alert(1)
                    location.reload();
                // }
            }.bind(this), // Bind 'this' to access the delete button
            error: function(xhr, status, error) {
                console.error('Error deleting task:', error);
            }
        });

    })

    let deleteTask = function(taskId) {
        alert(taskId)
    }
});


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