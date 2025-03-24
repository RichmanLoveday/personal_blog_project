@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Profile</h4>
                <h6>Admin Profile</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="profile-set">
                    <div class="profile-head">
                    </div>
                    <div class="profile-top">
                        <div class="profile-content">
                            <form action="{{ route('admin.update.profile.photo') }}" id="updatePhoto" method="post"
                                enctype="multipart/form-data" onsubmit="uploadProfilePhoto(event)">
                                @csrf
                                @method('PUT')
                                <div class="profile-contentimg text-center">
                                    <img style="width:100px; height:100px;" class=" mx-1 mt-2"
                                        src="{{ !is_null($admin->photo) ? asset($admin->photo) : asset('admin/assets/img/icons/person_icon.png') }}"
                                        alt="img" id="blah">
                                    <div class="profileupload">
                                        <input type="file" onchange="validatePhoto(this)" name="photo" id="imgInp"
                                            accept=".jpg, .jpeg, .png">
                                        <a href="javascript:void(0);"><img
                                                src="{{ asset('admin/assets/img/icons/edit-set.svg') }}" alt="img"></a>
                                    </div>
                                </div>
                                <button type="submit" hidden id="sumitPhoto"></button>
                            </form>

                            <div class="profile-contentname">
                                <h2>{{ Str::ucfirst($admin->firstName) . ' ' . Str::ucfirst($admin->lastName) }}
                                </h2>
                            </div>
                        </div>
                        <div class="ms-auto">
                            <button onclick="clearInputs()" type="button" class="btn btn-cancel" data-toggle="modal"
                                data-target="#changePassword">Change Password</button>
                        </div>
                    </div>
                </div>
                <form action="{{ route('admin.profile.update') }}" id="updateProfile" method="post"
                    onsubmit="updateProfile(event)">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="firstName" value="{{ Str::ucfirst($admin->firstName) }}"
                                    placeholder="William">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="lastName" value="{{ Str::ucfirst($admin->lastName) }}"
                                    placeholder="Castilo">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" disabled value="{{ Str::ucfirst($admin->email) }}"
                                    placeholder="william@example.com">
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" id="btn-update" class="btn btn-submit me-2">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="changePasswordTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordTitle">Change Password</h5>
                    <button onclick="clearInputs()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="changePasswordForm" action="{{ route('admin.changepassword') }}" onsubmit="changePassword(event)"
                    method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <div class="form-login mb-3">
                            <label>Old Password</label>
                            <div class="pass-group">
                                <input type="password" name="old_password" id="old_password"
                                    class="pass-input form-control clear" placeholder="Enter your old password">
                                <div class="invalid-feedback">
                                    <li></li>
                                </div>
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                        </div>
                        <div class="form-login mb-3">
                            <label>New Password</label>
                            <div class="pass-group">
                                <input type="password" name="password" id="password"
                                    class="pass-input form-control clear" placeholder="Enter your new password">
                                <div class="invalid-feedback"></div>
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                        </div>
                        <div class="form-login mb-3">
                            <label>Confirm Password</label>
                            <div class="pass-group">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="pass-input form-control clear" placeholder="Confirm your new password">
                                <div class="invalid-feedback"></div>
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="clearInputs()" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-save">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin/assets/js/profile.js') }}"></script>
@endsection
