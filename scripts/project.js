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
            <span class="status secondary"><?= getStatus(${project.project_status}, $status);?></span>
        </div>
        <div class="card-body">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Veniam porro quas sapiente, fugiat facere distinctio magnam. 
        </div>
        <div class="card-row">
            <span>${project.deadline}</span>
            <a href="project-details.php?id=${project.id}"
                class="inline-button">
                <i class="fa-solid fa-circle-info"></i>
                Mais detalhes...
            </a>
        </div>
    </li>
    
    `
}