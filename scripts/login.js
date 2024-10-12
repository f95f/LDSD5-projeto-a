import { fireError } from './toast.js';


$(document).ready(function () {

    $('#loginForm').submit(function(event) {
        event.preventDefault();
        
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
    

        if(!isSigninValid()) return;


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



let isSigninValid = function() {

    let username = $('#nome').val();
    let email = $('#email').val();
    let password = $('#senha').val();
    let confirmPassword =$('#confirmarSenha').val();
    
    if(!username || !email || !password || !confirmPassword) {
        fireError("Preencha os dados corretamente!");
        return false;
    }

    if(password !== confirmPassword) {
        fireError("As senhas não são iguais!", "Verifique sua senha");
        return false;
    }
    
    if(password.length < 6) {
        fireError("Sua senha deve ter pelo menos 6 caracteres.", "Senha muito fraca!");
        return false;
    }
    return true;

}