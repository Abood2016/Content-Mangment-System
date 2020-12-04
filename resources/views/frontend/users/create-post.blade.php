@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('front-assets/js/summernote/summernote-bs4.min.css') }}">
@endsection


@section('content')
<div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                <h3>Create Post</h3>

                <form action="{{ route('users.post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Title">
                        @error('title')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea type="text" name="description" class="form-control description"
                            placeholder="Description"></textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-4 ">
                            <label for="category_id">Category</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option disabled selected>Category</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-4 ">
                            <label for="comment_able">Comment Able</label>
                            <select name="comment_able" id="comment_able" class="form-control">
                                <option disabled selected>comment_able</option>
                                <option value="1" {{ old('comment_able') == '1' ? "selected":"" }}>
                                    Yes
                                </option>
                                <option value="0" {{ old('comment_able') == '0' ? "selected":"" }}>
                                    No
                                </option>
                            </select>
                            @error('comment_able')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-4">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option disabled selected>status</option>
                                <option value="1"  {{ old('status') == '1' ? "selected":"" }}>
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
                    <div class="row pt-4">
                        <div class="col-12">
                            <div class="file-loading">
                                <input type="file" name="images[]" multiple id="post-images">
                            </div>
                        </div>
                    </div>
                    <div class="form-group pt-4">
                        <button class="btn btn-primary" type="submit">Create</button>
                    </div>
                </form>

            </div>
            <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                @include('partial.frontend.users.side-bar')
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script src="{{ asset('front-assets/js/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(function() {
       $('.description').summernote({
        tabsize: 2,
        height: 120,
        toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
        ]
       }); 
       $('#post-images').fileinput({
            theme: "fa",
            maxFileCount: 5,
            allowedFileTypes: ['image'],
            showCancel: true,
            showRemove: false,
            showUpload: false,
            overwriteInitial: false,
            });
    });
</script>

@endsection