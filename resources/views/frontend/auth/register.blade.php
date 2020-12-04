@extends('layouts.app')

@section('content')

<section class="my_account_area pt--80 pb--55 bg--white">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-md-3">
                <div class="my__account__wrapper">
                    <h3 class="account__title">Register</h3>
                    <form  action="{{ route('front.register') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="account__form">
                            <div class="input__box">
                                <label for="name">Name <span>*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="input__box">
                                <label for="username">Username <span>*</span></label>
                                <input type="text" name="username" value="{{ old('username') }}">
                                @error('username')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="input__box">
                                <label for="email">E-mail <span>*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="input__box">
                                <label for="mobile">Mobile<span>*</span></label>
                                <input type="text" name="mobile" value="{{ old('mobile') }}">
                                @error('mobile')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="input__box">
                                <label>Password<span>*</span></label>
                                <input type="password" name="password">
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="input__box">
                                <label>Confirm Password<span>*</span></label>
                                <input type="password" name="password_confirmation">
                                @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                            <br>
                            <div class="form__btn">
                                <button type="submit">Register</button>
                            </div>
                            <a class="forget_pass" href="{{ route('front.show_login_form') }}">Login</a>
                        </div>
                    </form>
                </div>
            </div>
</section>


@endsection