import { fireError, fireSuccess } from './toast.js';
import { validateForm } from './validation.js';

$(document).ready(function () {

    $(document).on('click', '#showFormModal', function() {
        $('#createModal').fadeIn();
        $('.overlay').fadeIn();
    });
    
    $(document).on('click', '#closeCreateModal', function() {
        $('#createModal').fadeOut();
        $('.overlay').fadeOut();
    });
    
    $(document).on('click', '.showDetailsModal', function() {
        $('#detailsModal').fadeIn();
        $('.overlay').fadeIn(); 
    });
    
    $(document).on('click', '#closeDetailsModal', function() {
        $('#detailsModal').fadeOut();
        $('.overlay').fadeOut();
    });

    $('#addProjectForm').submit(function(event) {
        event.preventDefault();
    
        var formData = $(this).serialize();




        const fieldsToValidate = [
            { selector: '#projectName', errorMessage: 'O nome do projeto é obrigatório.', validationFn: (value) => !!value },
            { selector: '#projectDescription', errorMessage: 'A descrição do projeto é obrigatório.', validationFn: (value) => !!value },
            { selector: '#startDate', errorMessage: 'Data de início é obrigatória.', validationFn: (value) => !!value && !isNaN(Date.parse(value)) },
            { selector: '#deadline', errorMessage: 'Data fim é obrigatória.', validationFn: (value) => !!value && !isNaN(Date.parse(value)) }
        ];

        if (!validateForm(fieldsToValidate)) {

            fireError("Preencha todos os campos.");
            return;
        }



        $.ajax({
            url: '',
            type: 'POST',
            data: `${formData}&action=CREATE`,
            success: function(response) {
                location.reload();
                $('#taskDescription').val('');
            },
            error: function(xhr, status, error) {
                console.error('Error adding task:', error);
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
                    $('#projectList').empty();
                    response.message.forEach(function(project) {
                        $card = makeCard(project);
                        $('#projectList').append($card);
                    });
                } else {
                    console.error('Search not successful: ', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error adding task:', error);
            }
        });
    });
});

let makeCard = function(project) {
    return `

    <li class="card-item">
        <div class="card-row">
            <h3>
                <i class="fa-solid fa-sitemap icon"></i>
                ${project.project_name}     
            </h3>
            <span class="status secondary">
                ${project.project_status}
            </span>
        </div>
        <div class="card-body">
            ${project.project_description}
        </div>
        <div class="card-row">
            <span>${project.start_date}-${project.deadline}</span>
            <a href="project-details.php?id=${project.id}"
                class="inline-button">
                <i class="fa-solid fa-circle-info"></i>
                Mais detalhes...
            </a>
        </div>
    </li>
    
    `
}