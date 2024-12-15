
$('document').ready(function() {

    closeModals();

    $('#overlay').click(function() {
        hideModals();
    });

    $('#editButton').click(function() {
        closeModals();
        $('#overlay').fadeIn();
        $('#editModal').fadeIn();

    });

    $('#deleteButton').click(function() {
        let id = $(this).data('id');
        let type = $(this).data('type');
        deleteEvent(id, type);
    });

    $('#submitUpdate').click(function(event) { 
        event.preventDefault();

        let type = $(this).data('type');
        let formData = $('#editForm').serialize();
        const form = document.getElementById('editForm');
        const formFields = new FormData(form);

        const data = {};
        formFields.forEach((value, key) => {
            data[key] = value;
        });

        const taskFieldsToValidate = [
            { selector: '#description', errorMessage: 'Descrição da task é obrigatória.', validationFn: (value) => !!value },
            { selector: '#endDate', errorMessage: 'Deadline da task é obrigatória.', validationFn: (value) => !!value && !isNaN(Date.parse(value)) }
        ];

        const projectFieldsToValidate = [
            { selector: '#name', errorMessage: 'O nome do projeto é obrigatório.', validationFn: (value) => !!value },
            { selector: '#description', errorMessage: 'A descrição do projeto é obrigatório.', validationFn: (value) => !!value },
            { selector: '#startDate', errorMessage: 'Data de início é obrigatória.', validationFn: (value) => !!value && !isNaN(Date.parse(value)) },
            { selector: '#endDate', errorMessage: 'Data fim é obrigatória.', validationFn: (value) => !!value && !isNaN(Date.parse(value)) }
        ];

        let isValid = true;
        if(type === 'TASK') {

            if (!data.description) {
                fireError('Descrição da task é obrigatória.'); 
                isValid = false;
                return;
            }
            if(!data.endDate) {
                fireError('Deadline da task é obrigatória.');
                isValid = false;
                return;
            }
            
        }
        else {

            if (!data.name) {
                fireError('O nome do projeto é obrigatório.'); 
                isValid = false;
                return;
            }
            if(!data.description) {
                fireError('A descrição do projeto é obrigatório.');
                isValid = false;
                return;
            }
            if(!data.startDate) {
                fireError('Data de início é obrigatória.');
                isValid = false;
                return;
            }
            if(!data.endDate) {
                fireError('Data fim é obrigatória.');
                isValid = false;
                return;
            }
            

        }

        
        
        if(!isValid) return;
        let id = $(this).data('id');

        $.ajax({
            url: '',
            type: 'POST',
            data: `action=update&${formData}&type=${type}&id=${id}`,
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error adding task:', error);
            }
        });
    });

    $('#completed').change(function() {
        $.ajax({
            type: 'POST',
            url: '',
            data: `action=change-status&${$('#completeForm').serialize()}`,
            success: function(data) {
                console.info('Form submitted successfully', data);

                setStatus({ status: data, type: 'TASK' })
            }
        });
    });
    


});


// Função para deletar uma tarefa
function deleteEvent(id, type) {
  if (confirm("Tem certeza que deseja deletar este item?")) {
      fetch('', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `action=delete&type=${type}&task_id=${id}`
      })
      .then(data => {
          location.reload();
      })
      .catch(error => console.error('Erro:', error));
  }
}




function openDetails(details) {
    closeModals();

    $('#overlay').fadeIn();
    $('#detailsModal').fadeIn();

    if(details.type === "TASK") {
        $('#completeForm').removeClass('hidden');
        $('#type').text('Task')
    }
    else {
        $('#completeForm').addClass('hidden');
        $('#type').text('Projeto');
    }

    setStatus(details);
    setPriority(details);

    $('#eventDetails').text(details.title);
    $('#description').text(details.description);
    $('#createdAt').text(details.createdAt);
    $('#startDate').text(details.startDate);
    $('#endDate').text(details.endDate);
    $('#projectId').val(details.projectId || 0);
    $('#taskId').val(details.id || 0);
    $('#completed').prop('checked', details.status === 1);


    $('#submitUpdate').data('id', details.id);
    $('#submitUpdate').data('type', details.type);
    $('#deleteButton').data('id', details.id);
    $('#deleteButton').data('type', details.type);

    $('#editButton').click(() => { showEditModal(details) });

}


function showEditModal(details) {
    closeModals();
    $('#overlay').fadeIn();
    $('#editModal').fadeIn();

    if(details.type === "TASK") {
        $('#nameRow').addClass('hidden');
        $('#statusRow').addClass('hidden');
    }
    else {
        $('#nameRow').removeClass('hidden');
        $('#statusRow').removeClass('hidden');    
    }

    $('input#name').val(details.title || "Não disponível");
    $('textarea#description').val(details.description || details.title || "Não disponível");
    $('input#createdAt').val(details.createdAt || "Não disponível");
    $('input#startDate').val(details.startDate || "Não disponível");
    $('input#endDate').val(details.endDate || "Não disponível");
    $('select#priority').val(Number(details.priority) || 0);
    $('select#status').val(Number(details.status) || 0);
};

function closeModals() { 
    resetEditForm();
    $('#overlay').hide(); 
    $('#detailsModal').hide();
    $('#editModal').hide();
}

function hideModals() {  
    resetEditForm(); 
    $('#overlay').fadeOut();
    $('#detailsModal').fadeOut();
    $('#editModal').fadeOut();
}

function resetEditForm() {
    $('#editForm input[type="text"]').val('');
    $('#editForm textarea').val('');
    $('#editForm select').val('');
}

function setStatus(details) {

    const statuses = [
        { title: 'Backlog', color: 'info' },
        { title: 'Em progresso', color: 'secondary' },
        { title: 'Concluído', color: 'success' },
        { title: 'Parado', color: 'warning' },
        { title: 'Atrasado', color: 'danger' },
        { title: 'Cancelado', color: 'neutral' },
    ]

    if(details.type === "PROJECT") {
        const index = Number(details.status) -1;
        
        $('#status').text(statuses[index].title);
        $('#status').addClass(`status ${statuses[index].color}`);

    }
    else {
        $('#status').attr('class', '');
        $('#status').text(Number(details.status) === 0? 'Em progresso' : 'Concluído');
        $('#status').addClass(Number(details.status) === 0? 'status secondary' : 'status success');

    }
}

function setPriority(details){
    const priorities = [
        { title: 'Baixa', color: 'neutral' },
        { title: 'Média', color: 'success' },
        { title: 'Alta', color: 'warning' },
        { title: 'Crítica', color: 'danger' },
    ]

    if(details.priority) {
        const index = Number(details.priority) -1;
        
        $('#priority').text(priorities[index].title);
        $('#priority').addClass(`status ${priorities[index].color}`);
    }
    else {
        $('#priority').text('Não disponivel');    
    }

}


function validateForm(fields) {
    let isValid = true;
    $('.error-message').remove();

    fields.forEach(({ selector, errorMessage, validationFn }) => {
        console.warn(selector)
        const value = $(selector)?.val()?.trim();
        if (!validationFn(value)) {
            $(selector).before(`<span class="error-message">${errorMessage}</span>`);
            isValid = false;
        }
    });
  
    return isValid;
}


function fireError(message, title = "Erro") {

    $('#toastTitle').html(title);
    $('#icon').html(`<i class="fa-solid fa-circle-exclamation"></i>`);
    $('#toastMessage').text(message);
    
    $('#toast').fadeIn();
    $('#toast').click(function() {
        $(this).fadeOut();
    });

    setTimeout(() => { $('#toast').fadeOut(); }, 5000);
}
