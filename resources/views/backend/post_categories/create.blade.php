@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Create Category</h6>
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
        <form action="{{ route('admin.post_categories.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-8">
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-4">
                    <label for="status">Category Status</label>
                    <select name="status" id="status" class="form-control">
                        <option disabled selected>status</option>
                        <option value="1" {{ old('status') == '1' ? "selected":"" }}>
                            Active
                        </option>
                        <option value="0" {{ old('status') == '0' ? "selected":"" }}>
                            DeActive
                        </option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>
            </div>
            <div class="form-group pt-4">
                <button class="btn btn-primary" type="submit">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection