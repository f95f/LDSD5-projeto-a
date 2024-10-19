
export const clearForm = function(formId) {
    $(formId).find(
        'input[type=text], ' + 
        'input[type=email], ' +
        'textarea, ' +
        'input[type=date]').val('');
}
