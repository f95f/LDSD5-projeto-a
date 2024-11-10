$('document').ready(function() {

    closeModals();

    $('#overlay').click(function() {
        hideModals();
    });

    $('#editButton').click(function() {
        let id = $(this).data('id');
        deleteTask(id);
    });

    $('#deleteButton').click(function() {
        let id = $(this).data('id');
        let type = $(this).data('type');
        deleteEvent(id, type);
    });


});


// Função para deletar uma tarefa
function deleteEvent(id, type) {
    console.warn(type)
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
function updateTask(taskId, title, startDate, endDate) {
  fetch('', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `action=update&type=TASK&task_id=${taskId}&title=${encodeURIComponent(title)}&start_date=${startDate}&end_date=${endDate}`
  })
  .then(response => response.json())
  .then(data => {
      if (data.status === "success") {
          alert(data.message);
          location.reload();
      } else {
          alert(data.message);
      }
  })
  .catch(error => console.error('Erro:', error));
}

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

    details.type === 'TASK'? 
        $('#type').text('Task') : $('#type').text('Projeto');
    
    $('#eventDetails').text(details.title);
    $('#description').text(details.description || "Não disponível");
    $('#createdAt').text(details.createdAt || "Não disponível");
    $('#startDate').text(details.startDate || "Não disponível");
    $('#endDate').text(details.endDate || "Não disponível");

    $('#editButton').data('id', details.id);
    $('#deleteButton').data('id', details.id);
    $('#deleteButton').data('type', details.type);
}

function closeModals() {
    $('#overlay').hide();
    $('#detailsModal').hide();
    $('#editModal').hide();
}

function hideModals() {
    $('#overlay').fadeOut();
    $('#detailsModal').fadeOut();
    $('#editModal').fadeOut();
}