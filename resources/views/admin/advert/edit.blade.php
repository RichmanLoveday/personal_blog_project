@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Advert Management</h4>
                <h6>Edit Advert</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.advert.update') }}" id="advertForm" method="post" onsubmit="updateAdvert(event)">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" value="{{ $advert->id }}">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Advert Title</label>
                                <input type="text" id="title" class="" value="{{ $advert->title }}"
                                    name="title">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Advert Url</label>
                                <input type="text" id="url" value="{{ $advert->url }}" class=""
                                    name="url">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="startDate">Start Date</label>
                                <input id="start_date" value="{{ date('d-m-Y', strtotime($advert->start_date)) }}"
                                    oninput="determinEndDate(this)" type="text" name="start_date"
                                    class="datetimepicker cal-icon" placeholder="Choose Start Date">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input id="end_date" type="text"
                                    value="{{ date('d-m-Y', strtotime($advert->end_date)) }}" name="end_date"
                                    class="datetimepicker cal-icon" placeholder="Choose End Date">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h4>Advert Placement</h4>
                    <div class="row" id="placements">
                        @foreach ($advert->placements as $placement)
                            <div id="placement-group" class="col-12 row" data-placement-id="{{ $placement->id }}">
                                <input type="hidden" name="placements[{{ $placement->id }}][id]"
                                    value="{{ $placement->id }}">

                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Select Position</label>
                                        <select onchange="getPagesForBanner(this)"
                                            id="placements.{{ $placement->id }}.position"
                                            class="form-select position-select"
                                            name="placements[{{ $placement->id }}][position]">
                                            <option value="">Choose Position</option>
                                            <option @selected($placement->position == 'top_banner') value="top_banner">Top Banner</option>
                                            <option @selected($placement->position == 'footer_banner') value="footer_banner">Footer Banner
                                            </option>
                                            <option @selected($placement->position == 'whats_new_banner') value="whats_new_banner">Whats New Banner
                                            </option>
                                            <option @selected($placement->position == 'most_popular_banner') value="most_popular_banner">Most Popular
                                                Banner</option>
                                            <option @selected($placement->position == 'featured_banner') value="featured_banner">Featured Banner
                                            </option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Select Page</label>
                                        <select name="placements[{{ $placement->id }}][page]" id="placements.0.page"
                                            class="form-select page-select">
                                            <option value="{{ $placement->page }}">Choose Page</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label>Add Placement Image</label>
                                        <input type="file" id="placements.0.image"
                                            name="placements[{{ $placement->id }}][image]" onchange="previewImage(this)"
                                            class="form-control image">
                                        <div class="invalid-feedback"></div>
                                        <small class="text-muted mt-2 d-block"></small>
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-between mx-3">
                                    <img id="preview_image" style=" width:50px;height:50px;" accept="image/*"
                                        src="{{ is_null($placement->image) ? asset('admin/assets/img/icons/empty-image.png') : asset($placement->image) }}"
                                        alt="preview_image">
                                    <button type="button" data-placement-id="{{ $placement->id }}"
                                        class="btn btn-danger rounded-circle p-1" onclick="removePlacement(this, 'edit')"
                                        id="remove_placement_btn"><img
                                            src="{{ asset('admin/assets/img/icons/remove.png') }}" alt=""
                                            style="width:20px; height:20px;">
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-12 d-flex justify-content-end">
                            <button type="button" id="btn-submit" onclick="addMorePlacement(event)"
                                class="btn btn-sm btn-submit me-2">Add More
                                Placement</button>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" id="btn-submit" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ route('admin.advert.index') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('admin/assets/js/adverts.js') }}"></script>
@endsection
