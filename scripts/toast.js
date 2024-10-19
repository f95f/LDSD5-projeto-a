export const fireError = function(message, title = "Erro") {

    $('#toastTitle').html(title);
    $('#icon').html(`<i class="fa-solid fa-circle-exclamation"></i>`);
    $('#toastMessage').text(message);
    
    $('#toast').fadeIn();
    $('#toast').click(function() {
        $(this).fadeOut();
    });

    setTimeout(() => { $('#toast').fadeOut(); }, 5000);
}

export const fireSuccess = function(message, title = "Sucesso   ") {

    $('#toastTitle').html(title);
    $('#icon').html(`<i class="fa-solid fa-circle-check"></i>`);
    $('#toastMessage').text(message);
    
    $('#toast').fadeIn();
    $('#toast').click(function() {
        $(this).fadeOut();
    });

    setTimeout(() => { $('#toast').fadeOut(); }, 5000);
}