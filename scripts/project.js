$(document).ready(function () {

    $('#showFormModal').click(function() {
        $('#modal').fadeIn();
        $('#overlay').fadeIn();
    });

    $(document).on('click', '#closeModal', function(){
        $('#overlay').fadeOut();
        $('#modal').fadeOut();
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
