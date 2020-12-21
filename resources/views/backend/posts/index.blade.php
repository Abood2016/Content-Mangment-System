@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Posts</h6>
        <div class="ml-auto">
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-plus"></i>
                </span>
                <span class="text">Add new post</span>
            </a>

        </div>

    </div>
    @include('backend.posts.filter.filter')
    <div class="table-responsive">
        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Comments</th>
                    <th>Status</th>
                    <th>Category</th>
                    <th>User</th>
                    <th>Created Date</th>
                    <th class="text-center" style="width: 30px">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td><a href="{{ route('admin.posts.show',$post->id) }}">{!!
                            \Illuminate\Support\Str::limit($post->title,20 , '....') !!}</a></td>
                    <td>{!! $post->comment_able == 1 ? "<a href=\"". route('admin.post_comments.index',['post_id'=>
                            $post->id]) ."\">" . $post->comments->count() . "</a>" : 'Disallow' !!}</td>
                    <td><span class="badge badge-warning">{{ $post->status() }}</span></td>
                    <td><a href="{{ route('admin.post_categories.index',['category_id' => $post->category_id]) }}"><span
                                class="badge badge-secondary">{{ $post->category->name }}</span></a></td>
                    <td>{{ $post->user->name }}</td>
                    <td>{{ $post->created_at->format('d-m-Y h:i a') }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-primary"><i
                                    class="fa fa-edit"></i></a>
                            <a href="javascript:void(0)"
                                onclick="if (confirm('Are you sure to delete this post?') ) { document.getElementById('post-delete-{{ $post->id }}').submit(); } else { return false; }"
                                class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="post"
                                id="post-delete-{{ $post->id }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">No Posts Found</td>
                </tr>
            </tbody>
            @endforelse

            <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Comments</th>
                    <th>Status</th>
                    <th>Category</th>
                    <th>User</th>
                    <th>Created Date</th>
                    <th class="text-center" style="width: 30px"> Action</th>
                </tr>
            </tfoot>
            <tr>
                <th colspan="7">
                    <div class="float-right">
                        {!! $posts->appends(request()->input())->links() !!}
                    </div>
                </th>
            </tr>
        </table>
    </div>
</div>
@endsection