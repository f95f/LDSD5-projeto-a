$(document).ready(function () {

    $('#addTaskForm').hide();
    // $(document).on('click', '#showTaskModal', function() {
    //     $('#taskModal').fadeIn();
    //     $('.overlay').fadeIn();
    // });
    
    // $(document).on('click', '#closeTaskModal', function() {
    //     $('#taskModal').fadeOut();
    //     $('.overlay').fadeOut();
    // });
    
    // $(document).on('click', '.showDetailsModal', function() {
    //     $('#detailsModal').fadeIn();
    //     $('.overlay').fadeIn(); // Show overlay for details modal
    // });
    
    // $(document).on('click', '#closeDetailsModal', function() {
    //     $('#detailsModal').fadeOut();
    //     $('.overlay').fadeOut(); // Hide overlay when details modal is closed
    // });

    $('#addTaskForm').submit(function(event) {
        event.preventDefault();
    
        var formData = $(this).serialize();

        $.ajax({
            url: '',
            type: 'POST',
            data: `${formData}&action=ADD`,
            success: function(response) {
                // location.reload();
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
                action: 'DELETE',
                type: 'TASK',
            },
            success: function(response) {
                if (response.success) {
                    console.log('Received data:', response.received_data);
                    $(this).hide();
                }
            }.bind(this),
            error: function(xhr, status, error) {
                console.error('Error deleting task:', error);
            }
        });
    });
});
