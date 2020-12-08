@extends('layouts.app')


@section('content')
<div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                <h3 class="pb-4">Update Comment on Post | {{ $comment->post->title }}</h3>

                <form action="{{ route('users.comment.update',['comment_id' => $comment->id]) }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-3 ">
                            <label for="name">Name</label>
                            <input type="text" value="{{ $comment->name }}" name="name" class="form-control"
                                placeholder="name">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-3">
                            <label for="email">Email</label>
                            <input type="email" value="{{ $comment->email }}" name="email" class="form-control" placeholder="email">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label for="url">WebSite</label>
                            <input type="text" value="{{ $comment->url }}" name="url" class="form-control" placeholder="url">
                            @error('url')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-3">
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
                            <textarea type="text" cols="10" rows="10" name="comment" class="form-control"
                                placeholder="comment">{{ $comment->comment }}</textarea>
                            @error('comment')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                        <div class="form-group pt-4">
                        <button class="btn btn-primary" type="submit">Update </button>
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