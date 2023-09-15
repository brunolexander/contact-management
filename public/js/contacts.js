$(function() {

    $('#newContactModal').on('show.bs.modal', function() {
        $('.alert', this).hide()
        newContactForm.trigger('reset')
    });

    const newContactForm = $('#newContactForm').on('submit', (e) => e.preventDefault())
    const alertSuccess = $('#newContactModal .alert-success')
    const alertDanger = $('#newContactModal .alert-danger')
    const contactList = $('.contact-list .list-group')
    
    $('.btn-save').on('click', function() {
        const btnSave = $(this).hide()
        const btnSaveLoading = $('.btn-save-loading').show()

        $.ajax({
            method: 'POST',
            url: '/contacts/create',
            data: newContactForm.serialize(),
            dataType: 'json',
            complete: function() {
                btnSave.show()
                btnSaveLoading.hide()
            },
            success: function(data) {
                alertDanger.hide()
                alertSuccess.slideDown('fast')
                newContactForm.trigger('reset')
                contactList.append(data.html)
            },
            error: function(jqXHR) {
                const response = jqXHR.responseJSON;
                let message = response.message;

                if ('errors' in response)
                {
                   [message] = Object.values(response.errors)
                }

                $('.alert-message', alertDanger).text(message || 'An unexpected error occurred.')
                alertSuccess.hide()
                alertDanger.slideDown('fast')
            }
        })
    });
});