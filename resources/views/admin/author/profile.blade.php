@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Profile</h4>
                <h6>Author Profile</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="profile-set">
                    <div class="profile-head">
                    </div>
                    <div class="profile-top">
                        <div class="profile-content">
                            <div class="profile-contentimg">
                                <img class="mx-1 mt-2"
                                    src="{{ is_null($author->photo) ? asset('admin/assets/img/icons/person_icon.png') : asset($author->photo) }}"
                                    alt="img" id="blah">
                            </div>
                            <div class="profile-contentname">
                                <h2>{{ Str::ucfirst($author->firstName) . ' ' . Str::ucfirst($author->lastName) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" disabled value="{{ Str::ucfirst($author->firstName) }}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" disabled value="{{ Str::ucfirst($author->lastName) }}"
                                placeholder="Castilo">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" disabled value="{{ $author->email }}" placeholder="william@example.com">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label>Phone</label>
                            <input disabled type="text" value="{{ $author->phone }}" placeholder="+1452 876 5432">
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>About Me</label>
                            <textarea disabled style="resize:none" placeholder="About Me...." class=" form-control" name="" id=""
                                cols="30" rows="10">{{ $author->aboutMe }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
