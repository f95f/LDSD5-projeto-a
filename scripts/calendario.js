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
        console.warn(" Should be updating")
        let formData = $(this).serialize();
        let type = $(this).data('type');
        let id = $(this).data('id');

        $.ajax({
            url: '',
            type: 'POST',
            data: `action=update${formData}&type=${type}&id=${id}`,
            success: function(response) {
                // location.reload();
                fireSuccess("Task criada.");
            },
            error: function(xhr, status, error) {
                console.error('Error adding task:', error);
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


// Função para atualizar uma tarefa
// function updateTask(taskId, title, startDate, endDate) {
//   fetch('', {
//       method: 'POST',
//       headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//       body: `action=update&type=TASK&task_id=${taskId}&title=${encodeURIComponent(title)}&start_date=${startDate}&end_date=${endDate}`
//   })
//   .then(response => response.json())
//   .then(data => {
//       if (data.status === "success") {
//           alert(data.message);
//           location.reload();
//       } else {
//           alert(data.message);
//       }
//   })
//   .catch(error => console.error('Erro:', error));
// }

// Exemplo de uso: adicionar eventos de clique nas tarefas do calendário para editar ou deletar
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.calendar-task').forEach(task => {
      task.addEventListener('click', function() {
          const taskId = this.getAttribute('data-task-id');
          const taskTitle = prompt("Editar título da tarefa:", this.getAttribute('data-task-title'));
          const taskStartDate = prompt("Editar data de início (YYYY-MM-DD):", this.getAttribute('data-start-date'));
          const taskEndDate = prompt("Editar data de término (YYYY-MM-DD):", this.getAttribute('data-end-date'));

          if (taskTitle && taskStartDate && taskEndDate) {
              updateTask(taskId, taskTitle, taskStartDate, taskEndDate);
          }
      });

      task.querySelector('.delete-btn').addEventListener('click', function(event) {
          event.stopPropagation();
          const taskId = task.getAttribute('data-task-id');
          deleteTask(taskId);
      });
  });
});





function openDetails(details) {
    closeModals();

    $('#overlay').fadeIn();
    $('#detailsModal').fadeIn();

    const priorities = [
        { title: 'Baixa', color: 'neutral' },
        { title: 'Média', color: 'success' },
        { title: 'Alta', color: 'warning' },
        { title: 'Crítica', color: 'danger' },
    ]


    details.type === 'TASK'? 
        $('#type').text('Task') : $('#type').text('Projeto');

    if(details.priority) {
        const index = Number(details.priority) -1;
        
        $('#priority').text(priorities[index].title);
        $('#priority').addClass(`status ${priorities[index].color}`);
    }
    else {
        $('#priority').text('Não disponivel');    
    }

    $('#eventDetails').text(details.title);
    $('#description').text(details.description || "Não disponível");
    $('#createdAt').text(details.createdAt || "Não disponível");
    $('#startDate').text(details.startDate || "Não disponível");
    $('#endDate').text(details.endDate || "Não disponível");


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

    $('input#name').val(details.title || "Não disponível");
    $('textarea#description').val(details.description || "Não disponível");
    $('input#createdAt').val(details.createdAt || "Não disponível");
    $('input#startDate').val(details.startDate || "Não disponível");
    $('input#endDate').val(details.endDate || "Não disponível");
    $('select#priority').val(Number(details.priority) || 0);
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