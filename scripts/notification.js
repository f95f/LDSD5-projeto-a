$(document).ready(function () {

  $('#preferencesOverlay').hide();
  $('#preferencesModal').hide();

  $('#closeNotifications').click(function() {

    $('#notificationModal').removeClass('open');

  });


  $('#openNotifications').click(function() {

    $('#notificationModal').addClass('open');

  });

  
  $('#clearNotificationsButton').click(function() {

    $('#notificationCounter').fadeOut();
    $('.notification-card').fadeOut();
    $('.notification-content').html(
      `<div class="no-activity-container">
          <i class="fa-solid fa-calendar-check"></i>
          <h3>Tudo em dia!</h3>
          <span> Nenhuma atividade para mostrar. </span>
      </div>` 
    );

  });


  $('#preferencesButton').click(function() {
    $('#preferencesOverlay').fadeIn();
    $('#preferencesModal').fadeIn();
  });

  $('#preferencesOverlay').click(function() {  
    $('#preferencesOverlay').fadeOut();
    $('#preferencesModal').fadeOut();
  });

  $('#closePreferencesModal').click(function() {  
    $('#preferencesOverlay').fadeOut();
    $('#preferencesModal').fadeOut();
  });


  $('#submitPreferences').click(function() {  
    $('#preferencesOverlay').fadeOut();
    $('#preferencesModal').fadeOut();

    formData = $("#preferencesForm").serialize();

    $.ajax({
      url: '../scripts/preferences.php',
      type: 'POST',
      data: `${formData}&action=UPDATE_PREFERENCES`,
      success: function(response) {
          location.reload();
      },
      error: function(xhr, status, error) {
          console.error('Error updating preferences:', error);
      }
    });

    return false;
  });

});