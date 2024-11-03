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
        // console.info(" >> Info: ", fetchInfo)
        fetch('', {
          method: 'POST',
        //   headers: {
        //     'Content-Type': 'application/json'
        //   },
          body: JSON.stringify({
            // startDate: fetchInfo.startStr,
            // endDate: fetchInfo.endStr
          })
        })
        .then(response => response.json())
        .then(data => successCallback(data))
        .catch(error => failureCallback(error));
      }
    //   events: [
    //     {
    //       title: 'Event Example 1',
    //       start: '2024-11-10',
    //       end: '2024-11-12'
    //     },
    //     {
    //       title: 'Event Example 2',
    //       start: '2024-11-15'
    //     }
    //   ]
    });
    
    
    calendar.render();
  });