document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  
  // Initialize the calendar
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',  // Month view by default
    locale: 'pt-br',  // Set locale to Portuguese
    headerToolbar: {
      left: 'prev,next today',  // Buttons on the left
      center: 'title',          // Title in the center
      right: 'dayGridMonth,timeGridWeek,timeGridDay' // Views on the right
    },
    events: function(fetchInfo, successCallback, failureCallback) {
      // AJAX request to fetch events
      fetch('', {
        method: 'POST',
        body: JSON.stringify({})
      })
      .then(response => response.json())
      .then(data => successCallback(data))
      .catch(error => failureCallback(error));
    }
  });

  calendar.render();
});

// --- Novo código para edição e exclusão pelo calendário ---

// Função para deletar uma tarefa
function deleteTask(taskId) {
  if (confirm("Tem certeza que deseja deletar esta tarefa?")) {
      fetch('../services/task-service.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `action=delete&task_id=${taskId}`
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
}

// Função para atualizar uma tarefa
function updateTask(taskId, title, startDate, endDate) {
  fetch('../services/task-service.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `action=update&task_id=${taskId}&title=${encodeURIComponent(title)}&start_date=${startDate}&end_date=${endDate}`
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
