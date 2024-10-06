$(document).ready(function () {

    $(document).on('click', '#showFormModal', function() {
        $('#createModal').fadeIn();
        $('.overlay').fadeIn(); // Show overlay for create modal
    });
    
    $(document).on('click', '#closeCreateModal', function() {
        $('#createModal').fadeOut();
        $('.overlay').fadeOut(); // Hide overlay when create modal is closed
    });
    
    $(document).on('click', '.showDetailsModal', function() {
        $('#detailsModal').fadeIn();
        $('.overlay').fadeIn(); // Show overlay for details modal
    });
    
    $(document).on('click', '#closeDetailsModal', function() {
        $('#detailsModal').fadeOut();
        $('.overlay').fadeOut(); // Hide overlay when details modal is closed
    });

    $('#addProjectForm').submit(function(event) {
        event.preventDefault();
    
        var formData = $(this).serialize();

        $.ajax({
            url: '',
            type: 'POST',
            data: formData,
            success: function(response) {
                // location.reload();
                $('#taskDescription').val('');
            },
            error: function(xhr, status, error) {
                console.error('Error adding task:', error);
            }
        });
    });
});
