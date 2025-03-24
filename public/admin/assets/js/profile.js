// console.log(BASE_URL)
const csrfToken = $('meta[name="csrf-token"]').attr("content");
console.log(csrfToken)

async function changePassword(e) {
    e.preventDefault();
    let error = false;

    //? validate inputs
    if (!$('#password').val()) {
        $('#password')
            .addClass('is-invalid')
            .next()
            .text("Please password is required");

        error = true;
    } else {
        $('#password')
            .removeClass('is-invalid')
            .next()
            .text('');
    }


    if (!$('#old_password').val()) {
        $('#old_password')
            .addClass('is-invalid')
            .next()
            .text("Please old password is required");

        error = true;
    } else {
        $('#old_password')
            .removeClass('is-invalid')
            .next()
            .text("");

    }


    if (!$('#password_confirmation').val()) {
        $('#password_confirmation')
            .addClass('is-invalid')
            .next()
            .text("Please old password confirmation is required");

        error = true;
    } else {
        $('#password_confirmation')
            .removeClass('is-invalid')
            .next()
            .text("");
    }


    if (!error) {
        let url = $('#changePasswordForm').attr('action');
        //? show spinner
        $('#btn-save').attr('disabled', true).html(`<span class="spinner-border text-white" role="status"></span>`);
        $.ajax({
            url: url,
            method: "PUT",
            data: JSON.stringify({
                old_password: $("#old_password").val(),
                password: $("#password").val(),
                password_confirmation: $("#password_confirmation").val(),
            }),
            processData: false,
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                "Accept": "application/json",
            },
            success: function (res) {
                if (res.status == 'success') {
                    toastr.success(res.message);
                    $('.close').click();
                    $('#btn-save').attr('disabled', false).text('Save changes');
                }
            },
            error: function (xhr) {
                if (xhr.status == 422) {
                    $('#btn-save').attr('disabled', false).text('Save changes');
                    //? clear all errors
                    $('.clear').removeClass('is-invalid').next().empty();

                    let errors = xhr.responseJSON.errors;
                    // console.log(errors)

                    //? loop through errors
                    $.each(errors, function (key, messages) {
                        $(`#${key}`).addClass('is-invalid');

                        //? loop through messages
                        messages.forEach(message => {
                            $(`#${key}`).next().append(`<li>${message}</li>`);
                        });
                    });
                } else {
                    $('#btn-save').attr('disabled', false).text('Save changes');
                    toastr.error("Something went wrong!");
                }
            }
        });
    }
}

async function updateProfile(e) {
    e.preventDefault();

    $('#btn-update').attr('disabled', true).html(`<span class="spinner-border text-white" role="status"></span>`);
    let url = $('#updateProfile').attr('action');

    let form = $('#updateProfile')[0];
    let formData = new FormData(form)
    $.ajax({
        url: url,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            "Accept": "application/json",
        },
        success: function (res) {
            toastr.success(res.message);
            $('#btn-update').attr('disabled', false).text('Save changes');
            $('.clearForm').removeClass('is-invalid').next().empty();

        },
        error: function (xhr) {
            console.log(xhr)
            if (xhr.status == 422) {
                let errors = xhr.responseJSON.errors;
                $('#btn-update').attr('disabled', false).text('Save changes');
                $('.clearForm').removeClass('is-invalid').next().empty();

                $.each(errors, function (key, messages) {
                    $(`#${key}`).addClass('is-invalid');

                    //? loop through messages
                    messages.forEach(message => {
                        $(`#${key}`).next().append(`<li>${message}</li>`);
                    });
                });
            } else {
                $('#btn-update').attr('disabled', false).text('Save changes');
                toastr.error("Something went wrong!");
            }
        }
    });

}


function validatePhoto(input) {
    let file = input.files[0]; // Get the selected file

    let allowedTypes = ["image/jpeg", "image/png"];
    if (!allowedTypes.includes(file.type)) {
        $(input)
            .val('')
            .prop('src', `${BASE_URL}/public/admin/assets/img/icons/person_icon.png`);
        toastr.error('Please selected document is not allowed');

        return;
    }

    console.log('reached')
    $('#sumitPhoto').click();
}

function uploadProfilePhoto(event) {
    event.preventDefault();

    let form = $('#updatePhoto')[0];
    let formData = new FormData(form);

    $.ajax({
        url: $('#updatePhoto').attr('action'),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            "Accept": "application/json",
        },
        beforeSend: function (res) {
            toastr.info('Uploading photo...');
            $('#imgInp').prop('disabled', true);
        },
        success: function (res) {
            console.log(res);
            if (res.status == 'success') {
                toastr.success(res.message);
                $('#imgInp').prop('disabled', false);
            }
        },
        error: function (xhr) {
            console.error(xhr.responseJSON);
            toastr.error("Failed to update profile picture.");
            $('#imgInp').prop('disabled', false);
        }
    });
}


function clearInputs() {
    $('.clear').val('').removeClass('is-invalid').next().text('');
}