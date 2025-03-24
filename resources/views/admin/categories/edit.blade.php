@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Article Add Category</h4>
                <h6>Create new article Category</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.category.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" name="name" value="{{ $category->name }}"
                                    class="form-control @error('name') is-invalid @enderror">
                                <input type="hidden" name="category_id" value="{{ $category->id }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex">
                            <button type="submit" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ route('admin.all.category') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
