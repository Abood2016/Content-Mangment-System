@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Post Comments</h6>

    </div>
    @include('backend.post_comments.filter.filter')
    <div class="table-responsive">
        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Author</th>
                    <th width="30%">Comment</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th class="text-center" style="width: 30px">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($comments as $comment)
                <tr>
                    <td><img src="{{ get_gravatar($comment->email, 50) }}" class="img-circle"></td>
                    <td><a href="{!! $comment->url != '' ? $comment->url : 'javascript:void(0);' !!}"
                            target="_blank">{{ $comment->name }}</a> {{ $comment->user_id != '' ? '(Member)' : '' }}
                    </td>
                    <td>
                        {!! $comment->comment !!}
                        <div class="text-muted">
                            <a href="{{ route('admin.posts.show', $comment->post_id) }}">{{ $comment->post->title }}</a>
                        </div>
                    </td>


                    <td><span class="badge badge-warning">{{ $comment->status() }}</span></td>

                    <td>{{ $comment->created_at->format('d-m-Y h:i a') }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.post_comments.edit', $comment->id) }}" class="btn btn-primary"><i
                                    class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)"
                                onclick="if (confirm('Are you sure to delete this comment ?') ) { document.getElementById('comment-delete-{{ $comment->id }}').submit(); } else { return false; }"
                                class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            <form action="{{ route('admin.post_comments.destroy', $comment->id) }}" method="post"
                                id="comment-delete-{{ $comment->id }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">No comments Found</td>
                </tr>
            </tbody>
            @endforelse

            <tfoot>
                <tr>
                    <th>Image</th>
                    <th>Author</th>
                    <th>Comment</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th class="text-center" style="width: 30px">Action</th>
                </tr>
            </tfoot>
            <tr>
                <th colspan="7">
                    <div class="float-right">
                        {!! $comments->appends(request()->input())->links() !!}
                    </div>
                </th>
            </tr>
        </table>
    </div>
</div>
@endsection