$(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('[name="_token"]').val()
        }
    });

    $('.form-input-contact').on('input', function() {
        $(this).val(this.value.replace(/[^0-9]/, '').substring(0, 9))
    });

    $('#newContactModal').on('show.bs.modal', function() {
        $('.alert', this).hide()
        newContactForm.trigger('reset')
    });

    const newContactForm = $('#newContactForm').on('submit', (e) => e.preventDefault())
    const editContactForm = $('#editContactForm').on('submit', (e) => e.preventDefault())
    const contactList = $('.list-group.contact-list')
    const contactListFiltered = $('.list-group.contact-list-filtered')
    
    // Filter contacts
    const filterContactInput = $('.search-contact').on('input', function() {
        const term = this.value.trim()

        contactListFiltered.empty()
        $('.list-group-item[data-id]', contactList).filter(function (_, element) {
            const data = $(element).data()
            return (term.length === 0 || data.name.includes(term) || data.email.includes(term) || String(data.contact).includes(term))
        }).each((_, element) => contactListFiltered.append($(element).clone()))

        if ($('.list-group-item', contactListFiltered).length == 0) {
            contactListFiltered.append(`<li class="list-group-item text-center">
                No results found.
            </li>`);
        }
    }).trigger('input');

    const filterContacts = () => filterContactInput.trigger('input')

    // Add contact
    $('.btn-save').on('click', function() {
        const btnSave = $(this).hide()
        const btnSaveLoading = $('.btn-save-loading').show()
        const alertSuccess = $('#newContactModal .alert-success')
        const alertDanger = $('#newContactModal .alert-danger')

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
                $('.has-no-contacts', contactList).remove()
               
                filterContacts()
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

    // Edit contact
    const editContactModal = $('#editContactModal')

    $('body').on('click', '.btn-edit-contact', function() {
        const data = $(this).parents('li').data()
        $('.btn-update', editContactModal).val(data.id).prop('disabled', false)
        $('#editContactId').val(data.id)
        $('#editContactName').val(data.name)
        $('#editContactPhone').val(data.contact)
        $('#editContactEmail').val(data.email)
        $('.alert', editContactModal).hide()
        editContactModal.modal('show')
    });

    $('.btn-update', editContactModal).on('click', function() {
        const btnUpdate = $(this).hide()
        const btnUpdateLoading = $('.btn-update-loading').show()
        const alertSuccess = $('#editContactModal .alert-success')
        const alertDanger = $('#editContactModal .alert-danger')
        const contactId = this.value

        $.ajax({
            method: 'POST',
            url: '/contacts/save',
            data: editContactForm.serialize(),
            dataType: 'json',
            complete: function() {
                btnUpdate.show()
                btnUpdateLoading.hide()
            },
            success: function(data) {
                alertDanger.hide()
                alertSuccess.slideDown('fast')
                $('.list-group-item', contactList).filter((_, element) => $(element).data('id') == contactId).replaceWith(data.html)
                
                filterContacts()
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

    // Delete contact
    const deleteContactModal = $('#deleteContactModal')

    $('body').on('click', '.btn-delete-contact', function() {
        $('.btn-delete', deleteContactModal).val(this.value).prop('disabled', false)
        $('.alert', deleteContactModal).hide()
        deleteContactModal.modal('show')
    });

    $('.btn-delete', deleteContactModal).on('click', function() {
        const btnDelete = $(this).hide()
        const btnDeleteLoading = $('.btn-delete-loading').show()
        const alertSuccess = $('.alert-success', deleteContactModal)
        const alertDanger = $('.alert-danger', deleteContactModal)
        const contactId = this.value

        $.ajax({
            method: 'POST',
            url: '/contacts/destroy',
            data: {id: contactId},
            dataType: 'json',
            complete: function() {
                btnDelete.show()
                btnDeleteLoading.hide()
            },
            success: function(data) {
                btnDelete.prop('disabled', true)
                alertDanger.hide()
                alertSuccess.slideDown('fast')
                $('.list-group-item', contactList).filter((_, element) => $(element).data('id') == contactId).remove()

                if ($('.list-group-item', contactList).length == 0) {
                    contactList.append(`<li class="list-group-item text-center has-no-contacts">
                        There are no contacts registered.
                    </li>`);
                }

                filterContacts()
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