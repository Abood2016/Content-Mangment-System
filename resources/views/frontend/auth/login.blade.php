@extends('layouts.app')

@section('content')
<section class="my_account_area pt--80 pb--55 bg--white">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-md-3">
                    <div class="my__account__wrapper">
                        <h3 class="account__title">Login</h3>
                        <form method="POST" action="{{ route('front.login') }}">
                            @csrf
                            <div class="account__form">
                                <div class="input__box">
                                    <label for="username">Username <span>*</span></label>
                                    <input type="text" name="username" value="{{ old('username') }}">
                                    @error('username')
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
                                <div class="form__btn">
                                    <button type="submit">Login</button>
                                    <label class="label-for-checkbox">
                                        <input id="remember" class="input-checkbox" name="remember" type="checkbox">
                                        <span>Remember me</span>
                                    </label>
                                </div>
                                <a class="forget_pass" href="{{ route('front.password.request') }}">Lost your password?</a>
                            </div>
                        </form>
                    </div>
            </div>
</section>


@endsection
