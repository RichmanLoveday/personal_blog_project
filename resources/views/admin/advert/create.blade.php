@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Advert Management</h4>
                <h6>Add new Advert</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.advert.store') }}" id="advertForm" method="post" onsubmit="submitForm(event)">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Advert Title</label>
                                <input type="text" id="title" class="" name="title">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Advert Url</label>
                                <input type="text" id="url" class="" name="url">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="startDate">Start Date</label>
                                <input id="start_date" oninput="determinEndDate(this)" type="text"
                                    value="{{ old('startDate', request('startDate')) }}" name="startDate"
                                    class="datetimepicker cal-icon" placeholder="Choose Start Date">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="endDate">End Date</label>
                                <input id="end_date" type="text" value="{{ old('endDate', request('endDate')) }}"
                                    name="endDate" class="datetimepicker cal-icon" placeholder="Choose End Date">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h4>Advert Placement</h4>
                    <div class="row" id="placements">
                        <div id="placement-group" class="col-12 row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Select Position</label>
                                    <select onchange="getPagesForBanner(this)" id="placements.0.position"
                                        class="form-select position-select" name="placements[0][position]">
                                        <option value="">Choose Position</option>
                                        <option value="top_banner">Top Banner</option>
                                        <option value="footer_banner">Footer Banner</option>
                                        <option value="whats_new_banner">Whats New Banner</option>
                                        <option value="most_popular_banner">Most Popular Banner</option>
                                        <option value="featured_banner">Featured Banner</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Select Page</label>
                                    <select name="placements[0][page]" id="placements.0.page"
                                        class="form-select page-select">
                                        <option value="">Choose Page</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Add Placement Image</label>
                                    <input type="file" id="placements.0.image" name="placements[0][image]"
                                        onchange="previewImage(this)" class="form-control image">
                                    <div class="invalid-feedback"></div>
                                    <small class="text-muted mt-2 d-block"></small>
                                </div>
                                <img id="preview_image" style=" width:50px;height:50px;" accept="image/*"
                                    src="{{ asset('admin/assets/img/icons/empty-image.png') }}" alt="preview_image">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-12 d-flex justify-content-end">
                            <button type="button" id="btn-submit" onclick="addMorePlacement(event)"
                                class="btn btn-sm btn-submit me-2">Add More
                                Placement</button>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" id="btn-submit" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ route('admin.articles') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin/assets/js/adverts.js') }}"></script>
@endsection
