@extends('layouts.app')

@extends('layouts.app')

@section('content')
<section class="my_account_area pt--80 pb--55 bg--white">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-md-3">
                <div class="my__account__wrapper">
                    <h3 class="account__title">Password Reset</h3>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="account__form">
                            <div class="input__box">
                                <label for="email">Email <span>*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form__btn">
                                <button type="submit">Send Password Reset Link</button>

                            </div>
                            <a class="forget_pass" href="{{ route('front.show_login_form') }}">Login</a>
                        </div>
                    </form>
                </div>
            </div>
</section>



@endsection
