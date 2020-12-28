@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Pages</h6>
        <div class="ml-auto">
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-plus"></i>
                </span>
                <span class="text">Add new Page</span>
            </a>

        </div>

    </div>
    @include('backend.pages.filter.filter')
    <div class="table-responsive">
        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Category</th>
                    <th>User</th>
                    <th>Created Date</th>
                    <th class="text-center" style="width: 30px">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pages as $page)
                <tr>
                    <td>{{ $page->id }}</td>
                    <td><a href="{{ route('admin.pages.show',$page->id) }}">{!!
                            \Illuminate\Support\Str::limit($page->title,20 , '....') !!}</a></td>
                    <td><span class="badge badge-warning">{{ $page->status() }}</span></td>
                    <td><a href="{{ route('admin.pages.index',['category_id' => $page->category_id]) }}"><span
                                class="badge badge-secondary">{{ $page->category->name }}</span></a></td>
                    <td>{{ $page->user->name }}</td>
                    <td>{{ $page->created_at->format('d-m-Y h:i a') }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                           
                          <a href="javascript:void(0)"
                                onclick="if (confirm('Are you sure to delete this page?') ) { document.getElementById('page-delete-{{ $page->id }}').submit(); } else { return false; }"
                                class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            <form action="{{ route('admin.pages.destroy', $page->id) }}" method="post" id="page-delete-{{ $page->id }}"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">No Pages Found</td>
                </tr>
            </tbody>
            @endforelse

            <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
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
                        {!! $pages->appends(request()->input())->links() !!}
                    </div>
                </th>
            </tr>
        </table>
    </div>
</div>
@endsection