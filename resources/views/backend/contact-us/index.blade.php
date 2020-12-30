@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">Contact us</h6>
    </div>
    @include('backend.contact-us.filter.filter')
    <div class="table-responsive">
        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>From</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Created Date</th>
                    <th class="text-center" style="width: 30px">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($messages as $message)
                <tr>
                    <td><a href="{{ route('admin.contact_us.show',$message->id) }}">{{ $message->name }}</a></td>
                    <td>{{ $message->title }}</td>

                    <td>
                       @if($message->status == 1)
                        <span class="badge badge-success">{{ $message->status() }}</span>
                        @elseif($message->status == 0)
                        <span class="badge badge-warning">{{ $message->status() }}</span>
                        @endif
                    </td>
                    <td>{{ $message->created_at->format('d-m-Y h:i a') }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.contact_us.show',$message->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                           <a href="javascript:void(0)"
                                onclick="if (confirm('Are you sure to delete this message?') ) { document.getElementById('message-delete-{{ $message->id }}').submit(); } else { return false; }"
                                class="btn btn-danger"><i class="fa fa-trash"></i></a>
                            <form action="{{ route('admin.contact_us.destroy', $message->id) }}" method="post"
                                id="message-delete-{{ $message->id }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">No messages Found</td>
                </tr>
            </tbody>
            @endforelse

            <tfoot>
                <tr>
                    <th>From</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Created Date</th>
                    <th class="text-center" style="width: 30px">Action</th>
                </tr>
            </tfoot>
            <tr>
                <th colspan="7">
                    <div class="float-right">
                        {!! $messages->appends(request()->input())->links() !!}
                    </div>
                </th>
            </tr>
        </table>
    </div>
</div>
@endsection