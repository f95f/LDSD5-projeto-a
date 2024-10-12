$(document).ready(function () {

    $('#loginForm').submit(function(event) {
        event.preventDefault();
            console.warn($('#email').val(), $('#senha').val())
        if(!$('#email').val() || !$('#senha').val()) {
            fireError("Preencha os dados corretamente!");
            return;
        }

        var formData = $(this).serialize();
        
        $.ajax({
            url: '',
            type: 'POST',
            data: `${formData}&action=LOGIN`,
            success: function(response) {
                if(response.success && response.success === true) {
                    window.location.replace('/pages/inicio.php');
                }
                else {
                    fireError("Credenciais inválidas.", "Erro ao autenticar!");
                }
            },
            error: function(xhr, status, error) {
                console.error('Error logging in:', error);
            }
        });
    });

    $('#signinForm').submit(function(event) {
        event.preventDefault();
    
        var formData = $(this).serialize();
        
        $.ajax({
            url: '',
            type: 'POST',
            data: `${formData}&action=SIGNUP`,
            success: function(response) {
                window.location.replace('/pages/login.php');
            },
            error: function(xhr, status, error) {
                console.error('Error signing in:', error);
            }
        });
    });

});


let fireError = function(message, title = "Erro") {
    $('#toastTitle').html(`<i class="fa-solid fa-circle-exclamation"></i> ${title}`);
    $('#toastMessage').text(message);
    
    $('#toast').fadeIn();
    $('#toast').click(function() {
        $(this).fadeOut();
    });

    setTimeout(() => { $('#toast').fadeOut(); }, 5000);
}