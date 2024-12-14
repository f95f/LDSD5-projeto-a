import { fireError, fireSuccess } from './toast.js';
import { validateForm } from './validation.js';

$(document).ready(function () {
    $('#noteDetailsModal').hide();

    $(document).on('click', '#showFormModal', function() {
        $('#createModal').fadeIn();
        $('.overlay').fadeIn();
        
        $("#formModalTitle").text("Adicionar Diário");
        $("#submitDiario").text("Adicionar");
        $("#conteudoDiario").val('');
        $("#tituloDiario").val('');
        $("#idDiario").val('');
    });
    
    $(document).on('click', '#closeCreateModal', function() {
        $('#createModal').fadeOut();
        $('.overlay').fadeOut();
    });
    
    $('.detailsButton').click(function() {
        $('#noteDetailsModal').fadeIn();
        $('.overlay').fadeIn();

        var title = $(this).data('note-title');
        var content =  $(this).data('note-content');
        
        $("#detailTitle").text(title);
        $("#detailContent").text(content);
    });
    
    $(document).on('click', '#closeDetailsModal', function() {
        $('#noteDetailsModal').fadeOut();
        $('.overlay').fadeOut();
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
                        let card = makeCard(project);
                        $('#diarioList').append(card);
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
        $("#formModalTitle").text("Editar Diário");
        $("#submitDiario").text("Atualizar");
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
                        ${item.title} 
                    </h3>
                    <div class="actions-wrapper">
                        <a  role="button"
                            class="inline-button editButton"
                            data-note-title="${item.title}  "
                            data-note-content="${item.content} "
                            data-note-id="${item.id} ">
                            <i class="fa-solid fa-edit light-text"></i>
                        </a>
                        <span class="light-text">|</span>
                        <a  role="button"
                            class="inline-button deleteButton"
                            data-note-id="${item.id} ">
                            <i class="fa-solid fa-trash light-text"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    ${item.content}
                </div>
                
                <div class="card-row">
                    <a href="diario-details.php?id=${item.id}"
                        class="inline-button">
                        <i class="fa-solid fa-circle-info"></i>
                        Ver mais...
                    </a>
                </div>
            </li>
    
    `
}