import { fireError, fireSuccess } from './toast.js';
import { validateForm } from './validation.js';

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

    $('#addDiarioForm').submit(function(event) {
        event.preventDefault();
    
        var formData = $(this).serialize();




        const fieldsToValidate = [
            { selector: '#conteudoDiario', errorMessage: 'Informe o conteúdo da nota.', validationFn: (value) => !!value },
        ];

        if (!validateForm(fieldsToValidate)) {

            fireError("Preencha o diário corretamente!");
            return;
        }


console.warn(formData);
        $.ajax({
            url: '',
            type: 'POST',
            data: `${formData}&action=CREATE`,
            success: function(response) {
                location.reload();
                $('#conteudoDiario').val('');
                $('#tituloDiario').val('');
            },
            error: function(xhr, status, error) {
                console.error('Error adding note:', error);
            }
        });
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