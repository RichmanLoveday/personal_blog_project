@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Team Management</h4>
                <h6>Add new Team Member</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row flex-column justify-content-center align-items-center">
                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label>Position</label>
                            <input type="text" placeholder="">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Photo</label>
                            <input type="file" class=" form-control">
                        </div>
                    </div>

                    <div class="d-flex justify-content-center align-items-center">
                        <a href="javascript:void(0);" class="btn btn-submit me-2">Submit</a>
                        <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
