@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Edit {{ $comment->post->title }} | Comment</h6>
        <div class="ml-auto">
            <a href="{{ route('admin.post_comments.index') }}" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-home"></i>
                </span>
                <span class="text">Back</span>
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.post_comments.update', $comment->id) }}" method="POST">
            {{ method_field('PUT') }}
            @csrf
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="name">Comment Name {{ $comment->user_id != '' ? '(Memmber)' : ''}}</label>
                        <input type="text" name="name" value="{{ $comment->name }}" class="form-control"
                            placeholder="Name">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="email">Comment Name</label>
                        <input type="email" name="email" value="{{ $comment->email }}" class="form-control"
                            placeholder="Email">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="email">Url</label>
                        <input type="text" name="url" value="{{ $comment->url }}" class="form-control"
                            placeholder="Url">
                        @error('url')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="ip_address">Ip Address</label>
                        <input type="text" name="ip_address" value="{{ $comment->ip_address }}" class="form-control"
                            placeholder="ip_address">
                        @error('ip_address')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option disabled selected>Status</option>
                        <option value="1" {{ ($comment->status == '1' ? "selected":"") }}>
                            Active
                        </option>
                        <option value="0" {{ ($comment->status == '0' ? "selected":"") }}>
                            DeActive
                        </option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label for="comment">Comment</label>
                    <textarea type="text" cols="10" rows="5" name="comment" class="form-control"
                        placeholder="comment">{{ $comment->comment }}</textarea>
                    @error('comment')
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