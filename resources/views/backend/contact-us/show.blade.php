@extends('layouts.admin')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex">
        <h6 class="m-0 font-weight-bold text-primary">{{ $message->title }}</h6>
        <div class="ml-auto">
            <a href="{{ route('admin.contact_us.index') }}" class="btn btn-primary">
                <span class="icon text-white-50">
                    <i class="fa fa-home"></i>
                </span>
                <span class="text">Contact</span>
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
            <tbody>
                <tr>
                    <th>Title</th>
                    <td colspan="4">{{ $message->title }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>@if($message->status == 1)
                    <span class="badge badge-success">{{ $message->status() }}</span>
                    @elseif($message->status == 0)
                    <span class="badge badge-warning">{{ $message->status() }}</span>
                    @endif</td>
                </tr>
                <tr>
                    <th>From</th>
                    <td>{{ $message->name }}</td>
                </tr>
                <tr>
                    <th>Message</th>
                    <td>{!! $message->message !!}</td> 
                </tr>
                <tr>
                    <th>Created date</th>
                    <td>{{ $message->created_at->format('d-m-Y h:i a') }}</td>
                  
                </tr>
            </tbody>

        </table>
    </div>
</div>

@endsection