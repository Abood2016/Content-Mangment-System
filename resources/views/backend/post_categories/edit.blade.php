@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Edit {{ $category->name }} | Category</h6>
        <div class="ml-auto">
            <a href="{{ route('admin.post_categories.index') }}" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-home"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.post_categories.update', $category->id) }}" method="POST">
            {{ method_field('PUT') }}
            @csrf
            <div class="row">
                <div class="col-8">
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" name="name" value="{{ $category->name }}" class="form-control"
                            placeholder="Name">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-4">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option disabled selected>Status</option>
                        <option value="1" {{ ($category->status == '1' ? "selected":"") }}>
                            Active
                        </option>
                        <option value="0" {{ ($category->status == '0' ? "selected":"") }}>
                            DeActive
                        </option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>
            </div>


            <div class="form-group pt-4">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection