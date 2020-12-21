@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Edit {{ $post->title }} | Post</h6>
        <div class="ml-auto">
            <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-home"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            {{ method_field('PUT') }}
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $post->title }}"
                            placeholder="Title">
                        @error('title')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea type="text" name="description" id="summernote" class="form-control"
                            placeholder="Description">{{ $post->description }}</textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option disabled selected>Category</option>
                        @foreach($categories as $category)
                        <option value="{{$category->id}}" {{ ($category->id == $post->category->id ? "selected":"") }}>
                            {{$category->name}}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-4 ">
                    <label for="comment_able">Comment Able</label>
                    <select name="comment_able" id="comment_able" class="form-control">
                        <option disabled selected>Comment Able</option>
                        <option value="1" {{ ($post->comment_able == '1' ? "selected":"") }}>
                            Yes
                        </option>
                        <option value="0" {{ ($post->comment_able == '0' ? "selected":"") }}>
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
                        <option disabled selected>Status</option>
                        <option value="1" {{ ($post->status == '1' ? "selected":"") }}>
                            Active
                        </option>
                        <option value="0" {{ ($post->status == '0' ? "selected":"") }}>
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
                    <label for="images">Images</label>
                    <div class="file-loading">
                        <input type="file" name="images[]" multiple id="post-images">
                        @error('images')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group pt-4">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function () {
            $('#summernote').summernote({
                tabSize: 2,
                height: 200,
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
        theme: "fas",
        maxFileCount: {{ 5 -$post->media->count() }} ,
        allowedFileTypes: ['image'],
        showCancel: true,
        showRemove: false,
        showUpload: false,
        overwriteInitial: false,
        initialPreview: [
        @if($post->media->count() > 0)
        @foreach($post->media as $media)
        "{{ asset('assets/posts/' . $media->image_name) }}",
        @endforeach
        @endif
        ],
        initialPreviewAsData: true,
        initialPreviewFileType: 'image',
        initialPreviewConfig: [
        @if($post->media->count() > 0)
        @foreach($post->media as $media)
        {caption: "{{ $media->image_name }}",
        size: {{ $media->image_size }},
        width: "120px",
        url: "{{ route('admin.posts.media.destroy', [$media->id, '_token' => csrf_token()]) }}", key: "{{ $media->id }}"},
        @endforeach
        @endif
        ],
        
        });
        });
</script>
@endsection