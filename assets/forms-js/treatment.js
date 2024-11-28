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



$('.delete-treatment-btn').on('click', async function () {
    var treatment_id = $(this).data('id');
    var is_confirm = confirm('Are you sure,Do you want to delete?');
    if (is_confirm) await deleteById(treatment_id);
})
async function deleteById(treatment_id) {
    var url = $('#update-form').attr('action');
alert('here');
    // Perform AJAX request
    $.ajax({
        url: url,
        type: 'GET',
        data: {
            id: treatment_id,
            action: 'delete_treatment',
        }, // Form data
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                showAlert(response.message, response.success ? 'primary' : 'danger', 'delete-alert-container');
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
}
