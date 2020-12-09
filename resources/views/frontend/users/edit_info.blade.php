@extends('layouts.app')

@section('content')
<div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12">
                <div class="blog-page">
                    <h3 class="pb-4">Update Information for | {{ auth()->user()->name }}</h3>
                    <form action="{{ route('users.update.info') }}" name="update-info" id="update-info" method="POST" enctype="multipart/form-data">
                        @csrf
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
                                <label for="mobile">mobile</label>
                                <input type="text" class="form-control" name="mobile"
                                    value="{{ auth()->user()->mobile }}">
                                @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-3">
                                <label for="receive_emails">Receive emails</label>
                                <select name="receive_emails" class="form-control">
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
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="bio">Bio</label>
                                    <textarea type="text" cols="10" rows="10" name="bio" class="form-control" placeholder="bio">{{ auth()->user()->bio }}</textarea>
                                    @error('bio')
                                    <span class="text-danger">{{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            @if (auth()->user()->image != '')
                            <div class="col-12">
                                <img src="{{ asset('front-end/users/' . auth()->user()->image) }}" width="170px"
                                    height="130px" class="img-fluid" style="border-radius: 20px;">
                            </div>
                            @endif
                            <div class="col-12 pt-4">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="">Upload</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group pt-4">
                                    <button class="btn btn-primary" type="submit">Update Your Information</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <hr><br>

                    <h3 class="pb-4">Update Password for | {{ auth()->user()->name }}</h3>
                    <form action="{{ route('users.update.password') }}" name="update-password" id="update-password"
                        method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control" name="current_password">
                                @error('current_password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-4">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" name="password">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-4">
                                <label for="mobile">Password Confirmation</label>
                                <input type="password_confirmation" class="form-control" name="password_confirmation">
                                @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group pt-4">
                                    <button class="btn btn-primary" type="submit">Update Your Password</button>
                                </div>
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