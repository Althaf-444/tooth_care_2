$('#create').on('click', function () {
    var form = $('#create-form')[0] ?? null;
    if (!form) console.log('Something went wrong..');

   

    var url = $('#create-form').attr('action');
    if (form.checkValidity() && form.reportValidity()) {
        var formData = new FormData(form);
        // Perform AJAX request
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false, // Don't set content type
            processData: false, // Don't process the data
            dataType: 'json',
            success: function (response) {
                showAlert(response.message, response.success ? 'primary' : 'danger');
                if (response.success) {
                    $('#createUserModal').modal('hide');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            },
            error: function (error) {
                // Handle the error
                console.error('Error submitting the form:', error);
                showAlert('Something went wrong..!', 'danger');
            },
            complete: function (response) {
                // This will be executed regardless of success or error
                console.log('Request complete:', response);

            }
        });


    } else {
        showAlert('Form is not valid. Please check your inputs.', 'danger');
    }
});

$('.edit-user-btn').on('click', async function () {
    var user_id = $(this).data('id');
    await getUserById(user_id);
})

$('.delete-user-btn').on('click', async function () {
    var user_id = $(this).data('id');
    var permission = $(this).data('permission');
    var is_confirm = confirm('Are you sure,Do you want to delete?');
    if (is_confirm) await deleteById(user_id, permission);
})

$('#update-user').on('click', function () {
    if (!validatePasswords('password', 'confirm-password')) {
        showAlert('Passwords do not match..!', 'danger', 'edit-alert-container'); // Prevent form submission if passwords do not match
        return;
    }
    // Get the form element
    var form = $('#update-form')[0];
    form.reportValidity();

    // Check form validity
    if (form.checkValidity()) {
        // Serialize the form data
        var url = $('#update-form').attr('action');
        var formData = new FormData($('#update-form')[0]);

        // Perform AJAX request
        $.ajax({
            url: url,
            type: 'POST',
            data: formData, // Form data
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                showAlert(response.message, response.success ? 'primary' : 'danger', 'edit-alert-container');
                if (response.success) {
                    $('#edit-user-modal').modal('hide');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            },
            error: function (error) {
                // Handle the error
                console.error('Error submitting the form:', error);
            },
            complete: function (response) {
                // This will be executed regardless of success or error
                console.log('Request complete:', response);
            }
        });
    } else {
        var message = ('Form is not valid. Please check your inputs.');
        showAlert(message, 'danger');
    }
});

