@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Pages | {{ $page->title }}</h6>
        <div class="ml-auto">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-home"></i>
                </span>
                <span class="text">Posts</span>
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
        <tbody>
            <tr>
                <td colspan="4">{{ $page->title }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $page->status() }}</td>
            </tr>
            <tr>
                <th>Category</th>
                <td>{{ $page->category->name }}</td>
                <th>Author</th>
                <td>{{ $page->user->name }}</td>
            </tr>
            <tr>
                <th>Created date</th>
                <td>{{ $page->created_at->format('d-m-Y h:i a') }}</td>
                <th></th>
                <td></td>
            </tr>
            <tr>
                <td colspan="4">
                    <div class="row">
                        @if($page->media->count() > 0)
                        @foreach($page->media as $media)
                        <div class="col-2">
                            <img src="{{ asset('assets/posts/' . $media->image_name) }}" style="border-radius: 10px" class="img-fluid">
                        </div>
                        @endforeach
                        @endif
                    </div>
                </td>
            </tr>
        </tbody>

        </table>
    </div>
</div>

@endsection