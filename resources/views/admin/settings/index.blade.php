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
                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="number" class=" form-control">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Facebook link</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-12">
                        <div class="form-group">
                            <label>Twitter Link</label>
                            <input type="text">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Our Mission</label>
                            <textarea class=" form-control" style="resize: none" name="" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Our Vission</label>
                            <textarea class=" form-control" style="resize: none" name="" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Our Best Services</label>
                            <textarea class=" form-control" style="resize: none" name="" id="" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="">
                        <a href="javascript:void(0);" class="btn btn-submit me-2">Submit</a>
                        <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
