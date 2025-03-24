@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Author Management</h4>
                <h6>Add new Author</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.author.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" value="{{ old('firstName') }}"
                                    class="@error('firstName') is-invalid @enderror form-control" name="firstName">
                                @error('firstName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" value="{{ old('lastName') }}"
                                    class="@error('lastName') is-invalid @enderror" name="lastName">
                                @error('lastName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="number" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" placeholder="+1452 876 5432" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Author Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <div class="pass-group">
                                    <label>Password</label>
                                    <input type="password" name="password"
                                        class="pass-input @error('password') is-invalid @enderror" placeholder=""
                                        value="{{ old('password') }}">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <span class="fas toggle-password fa-eye-slash" style="margin-top: 12px"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="form-group">
                                <div class="pass-group">
                                    <label>Confirm Password</label>
                                    <input type="password" name="password_confirmation"
                                        class="pass-input @error('password_confirmation') is-invalid @enderror"
                                        placeholder="">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <span class="fas toggle-password fa-eye-slash" style="margin-top: 12px"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Select Role</label>
                                <select class="select @error('role') is-invalid @enderror" name="role">
                                    <option value="">Choose Role</option>
                                    <option value="author" @selected(old('role'))>Author</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ route('admin.all.author') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if (session('status'))
        <script>
            $(document).ready(function() {
                toastr.success("{{ session('status') }}");
            });
        </script>
    @endif
@endsection
