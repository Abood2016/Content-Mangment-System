@extends('layouts.app')

@section('content')



<section class="my_account_area pt--80 pb--55 bg--white">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-md-3">
                <div class="my__account__wrapper">
                    <h3 class="account__title">Reset Password</h3>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="account__form">
                            <div class="input__box">
                                <label for="email">Email <span>*</span></label>
                                <input type="text" name="email" value="{{ old('email') }}">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input__box">
                                <label>New Password<span>*</span></label>
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
                            <div class="form__btn">
                                <button type="submit">Reset Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
</section>

@endsection
