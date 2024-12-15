
export const validateForm = function(fields) {
  let isValid = true;
  $('.error-message').remove();

  fields.forEach(({ selector, errorMessage, validationFn }) => {
      const value = $(selector).val().trim(); console.warn(" > ", value)
      if (!validationFn(value)) {
          $(selector).before(`<span class="error-message">${errorMessage}</span>`);
          isValid = false;
      }
  });

  return isValid;
}