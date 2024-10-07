$(document).ready(function () {

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
            data: formData,
            success: function(response) {
                // location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error adding task:', error);
            }
        });
    });
});
