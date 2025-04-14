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
                <form action="{{ route('admin.advert.store') }}" id="advertForm" method="post" onsubmit="addNewAdvert(event)">
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
                                <input type="text" id="title" class="" name="title">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="tagInput">Search tags</label>
                                <input oninput="searchTag(this)" type="text" id="tagInput" name="tags"
                                    data-role="{{ Auth::user()->role }}" list="tagSuggestions" class="form-control"
                                    placeholder="Enter or select a tag">
                                <datalist id="tagSuggestions"></datalist>
                                <button type="button" class=" btn btn-sm btn-primary mt-2"
                                    onclick="addTag(this)">Add</button>
                            </div>
                            <div class="d-flex gap-2 flex-wrap mb-2" id="tags-container"></div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Article Status</label>
                                <select class="select" id="status" name="status">
                                    <option value="">Choose Status</option>
                                    <option value="draft">Draft</option>
                                    <option value="published">Publish</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Select News Type</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="trending_news" id="trending_news">
                                    <label class="form-check-label" for="trending_news">Trending News</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="featured_news" id="featured_news">
                                    <label class="form-check-label" for="featured_news">Featured News</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <div class="form-group">
                                <label>Add Article Image</label>
                                <input type="file" id="image" name="image" onchange="previewImage(this)"
                                    class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                            <img id="preview_image" style=" width:80px;height:80px;" accept="image/*"
                                src="{{ asset('admin/assets/img/icons/empty-image.png') }}" alt="preview_image">
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

    <script src="{{ asset('admin/assets/js/articles.js') }}"></script>
@endsection
