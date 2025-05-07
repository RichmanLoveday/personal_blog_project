@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Settings Management</h4>
                <h6>Add/Update Settings</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.setting.update') }}" onsubmit="submitForm(event)" id="settingsForm"
                    method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="number" name="phone"
                                    value="{{ isset($settings->phone) ? $settings->phone : '' }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email_link"
                                    value="{{ isset($settings->email_link) ? $settings->email_link : '' }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Facebook link</label>
                                <input type="text" name="facebook_link"
                                    value="{{ isset($settings->facebook_link) ? $settings->facebook_link : '' }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Twitter Link</label>
                                <input type="text" name="twitter_link"
                                    value="{{ isset($settings->twitter_link) ? $settings->twitter_link : '' }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Our Mission</label>
                                <textarea name="our_mission" class="form-control" style="resize: none" name="" id="" cols="30"
                                    rows="10">{{ isset($settings->our_mission) ? $settings->our_mission : '' }}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Our Vission</label>
                                <textarea name="our_vission" class="form-control" style="resize: none" name="" id="" cols="30"
                                    rows="10">{{ isset($settings->our_vission) ? $settings->our_vission : '' }}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Our Best Services</label>
                                <textarea name="our_best_services" class=" form-control" style="resize: none" name="" id=""
                                    cols="30" rows="10">{{ isset($settings->our_best_services) ? $settings->our_best_services : '' }}</textarea>
                            </div>
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-submit me-2">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const csrf = $('meta[name="csrf-token"]').attr("content");

        function submitForm(event) {
            event.preventDefault();

            let form = $('#settingsForm')[0];
            let formData = new FormData(form);

            $.ajax({
                url: form.action,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": csrf,
                    "Accept": "application/json",
                },
                beforeSend: function() {
                    $('#submit').prop('disabled', true).text('Submitting...');
                    $('#btn-submit').prop('disabled', true);
                    //? disable cloz
                },
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        $('#btn-submit').prop('disabled', false);

                    } else if (response.status === 'error') {
                        toastr.error('An error occurred while creating advert!');
                        $('#btn-submit').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            const ele = $(`[name="${key}"]`);
                            ele.addClass('is-invalid');
                            ele.next('.invalid-feedback').text(value[0]);
                        });
                    } else if (status === 500) {
                        toastr.error('An error occured while creating advert');
                    }

                    //? undisable button
                    $('#btn-submit').prop('disabled', false);
                },
                complete: function() {
                    $('#submit').prop('disabled', false).text('Submit');
                    //? undisable button
                    $('#btn-submit').prop('disabled', false);
                }

            })
        }
    </script>
@endsection
