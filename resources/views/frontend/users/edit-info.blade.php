@extends('layouts.app')

@section('content')
<div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                <div class="blog-page">
                    <h3 class="pb-4">Update Information for | {{ auth()->user()->name }}</h3>
                    <form action="{{ route('users.update.info') }}" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-3">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="email"
                                    value="{{ auth()->user()->email }}">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-3">
                                <label for="mobile">Mobile</label>
                                <input type="text" class="form-control" name="mobile"
                                    value="{{ auth()->user()->mobile }}">
                                @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-3">
                                <label for="receive_emails">Receive emails</label>
                                <select name="status" id="status" class="form-control">
                                    <option disabled selected>Receive Emails </option>
                                    <option value="1" {{ (auth()->user()->receive_emails == '1' ? "selected":"") }}>
                                        Yes
                                    </option>
                                    <option value="0" {{ (auth()->user()->receive_emails == '0' ? "selected":"") }}>
                                        No
                                    </option>
                                </select>
                                @error('receive_emails')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            @if (auth()->user()->image != '')
                                <div class="col-12">
                                    <img src ="{{ asset('front-end/users/' . auth()->user()->image) }}" style="border-radius: 20px">
                                </div>
                            @endif
                            <div class="col-12 pt-4">
                                <label for="bio">Bio</label>
                                <textarea type="text" cols="10" rows="10" name="bio" class="form-control"
                                    placeholder="bio">{{ auth()->user()->bio }}</textarea>
                                @error('bio')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                </form>
            </div>
        </div>
        <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
            @include('partial.frontend.users.side-bar')
        </div>
    </div>
</div>
</div>
@endsection