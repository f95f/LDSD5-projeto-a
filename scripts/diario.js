import { fireError, fireSuccess } from './toast.js';
import { validateForm } from './validation.js';

$(document).ready(function () {

    $(document).on('click', '#showFormModal', function() {
        $('#createModal').fadeIn();
        $('.overlay').fadeIn(); // Show overlay for create modal
        
        $("#conteudoDiario").val('');
        $("#tituloDiario").val('');
        $("#idDiario").val('');
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

    $('#addDiarioForm').submit(function(event) {
        event.preventDefault();
    
        var formData = $(this).serialize();

        const id = $("#idDiario").val() || 0;
        
        const fieldsToValidate = [
            { selector: '#conteudoDiario', errorMessage: 'Informe o conteúdo da nota.', validationFn: (value) => !!value },
        ];

        if (!validateForm(fieldsToValidate)) {

            fireError("Preencha o diário corretamente!");
            return;
        }


        if(id && id > 0) { // Edição
            $.ajax({
                url: '',
                type: 'POST',
                data: `${formData}&action=UPDATE`,
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error updating note:', error);
                }
            });
        }
        else { // Criação
            $.ajax({
                url: '',
                type: 'POST',
                data: `${formData}&action=CREATE`,
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error adding note:', error);
                }
            });
        }

    });

    $('#searchForm').submit(function(event) {
        event.preventDefault();
    
        var formData = $(this).serialize();

        $.ajax({
            url: '',
            type: 'POST',
            data: `${formData}&action=SEARCH`,
            success: function(response) {

                if (typeof response === 'string') {
                    response = JSON.parse(response);
                }

                if (response.success) {
                    $('#diarioList').empty();
                    response.message.forEach(function(project) {
                        $card = makeCard(project);
                        $('#diarioList').append($card);
                    });
                } else {
                    console.error('Search not successful: ', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error adding note:', error);
            }
        });
    });


    $('.deleteButton').click(function(event) {
        event.preventDefault();
    
        var id = $(this).data('note-id');
    
        $.ajax({
            url: '',
            type: 'POST',
            data: `id=${id}&action=DELETE`,
            success: function(response) {
                fireSuccess("DIário exluída com sucesso.");

                $(this).closest('.card-item').remove();
            }.bind(this),
            error: function(xhr, status, error) {
                console.error('Error deleting note:', error);
            }
        });
    });


    $('.editButton').click(function(event) {
        event.preventDefault();
    
        var id = $(this).data('note-id');
        var title = $(this).data('note-title');
        var content =  $(this).data('note-content');
    
        console.log(id, title, content);
        $("#tituloDiario").val(title);
        $("#conteudoDiario").val(content);
        $("#idDiario").val(id);

        $('#createModal').fadeIn();
        $('.overlay').fadeIn(); 

    });
});

let makeCard = function(item) {
    return `

    <li class="card-item">
        <div class="card-row">
            <h3>
                <i class="fa-solid fa-book"></i>
                ${item.titulo_diario}  
            </h3>
            <span class="status secondary">
                ${item.conteudo_diario}
            </span>
        </div>
        <div class="card-row">
            <a href="diario-details.php?id=${item.id}"
                class="inline-button">
                <i class="fa-solid fa-circle-info"></i>
                Mais detalhes...
            </a>
        </div>
    </li>
    
    `
}