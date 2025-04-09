const csrf = $('meta[name="csrf-token"]').attr("content");
function subscribe(ele) {
    ele.preventDefault()

    let form = $('#subscibtionForm')[0];
    let formData = new FormData(form);

    $.ajax({
        url: $('#subscibtionForm').attr('action'),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            "X-CSRF-TOKEN": csrf,
            "Accept": "application/json",
        },
        beforeSend: function (res) {
            $('#btn-submit').prop('disabled', true).html(`<span class="spinner-border spinner-border-sm text-dark" role="status" aria-hidden="true"></span> Loading...`);
        },
        success: function (res) {
            console.log(res);
            if (res.status == 'success') {
                $('#btn-submit').prop('disabled', false).text('SUBCRIBE');

                toastr.success(res.message);
                $('#subscibtionForm')[0].reset();
            }
        },
        error: function (xhr) {
            console.log(xhr);
            $('#btn-submit').prop('disabled', false).text('SUBCRIBE');
            if (xhr.status == 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function (key, messages) {
                    //? loop through messages
                    messages.forEach(message => {
                        toastr.error(message);
                    });
                });

            } else if (xhr.status == 409) {
                toastr.error(xhr.responseJSON.message);
            } else {
                toastr.error('An error occured while uploading article');
            }
        }
    });
}


(function getLocation() {
    const apiKey = '338dbfc283084188b85109d073afb93b';
    $.ajax({
        url: `https://api.ipgeolocation.io/ipgeo?apiKey=${apiKey}`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $('#user_ip').val(data.ip);
            $('#user_country').val(data.country_name);
            $('#user_city').val(data.city);
            $('#user_region').val(data.state_prov);
        },
        error: function (xhr, status, error) {
            console.error('Geo API Error:', error);
        }
    });
})();

