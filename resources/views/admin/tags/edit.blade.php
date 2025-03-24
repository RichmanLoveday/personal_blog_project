@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Article Add Edit</h4>
                <h6>Edit article Tag</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.tag.update') }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Tag Name</label>
                                <input type="text" value="{{ $tag->name }}"
                                    class="form-control @error('name') is-invalid @enderror" name="name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <input type="text" hidden name="id" value="{{ $tag->id }}">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ route('admin.tags') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
