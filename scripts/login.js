$(document).ready(function () {

    $('#loginForm').submit(function(event) {
        event.preventDefault();
    
        var formData = $(this).serialize();
        
        $.ajax({
            url: '',
            type: 'POST',
            data: formData,
            success: function(response) {
                window.location.replace('/pages/inicio.php');
            },
            error: function(xhr, status, error) {
                console.error('Error logging in:', error);
            }
        });
    });
});
