<?php
  session_start();
?>
@extends('layouts.app')

<style>
.login-block {
	float: left;
	width: 100%;
	padding: 170px 0;
}

.banner-sec {
	background: url(http://saheicore.tech/wp-content/uploads/2020/12/sahei-core-tech-business-and-it-768x461.jpg) no-repeat left bottom;
	background-size: cover;
	min-height: 500px;
	border-radius: 0 10px 10px 0;
	padding: 0;
}

.container {
	background: #fff;
	border-radius: 10px;
	box-shadow: 15px 20px 0px rgba(0, 0, 0, 0.1);
}

.login-sec {
	padding: 50px 30px;
	position: relative;
}

.login-sec .copy-text {
	position: absolute;
	width: 80%;
	bottom: 20px;
	font-size: 13px;
	text-align: center;
}

.login-sec h2 {
	margin-bottom: 30px;
	font-weight: 800;
	font-size: 30px;
	color: #007bff;
}

.login-sec h2:after {
	content: " ";
	width: 100px;
	height: 5px;
	background: #007bff;
	display: block;
	margin-top: 20px;
	border-radius: 3px;
	margin-left: auto;
	margin-right: auto
}

.btn-login {
	background: #007bff;
	color: #fff;
	font-weight: 600;
}
</style>

@section('content')
<section class="login-block">
    <div class="container">
	    <div class="row">
            <div class="col-md-4 login-sec">
                <h2 class="text-center">House of Z POS LOGIN</h2>
                <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1" class="text-uppercase">E-Mail Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1" class="text-uppercase">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

            <!-- <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div> -->

                <div class="form-check">
                    <button type="submit" class="btn btn-login float-right">
                        {{ __('Login') }}
                    </button>
                </div>
                <!-- @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif -->
                </form>
            </div>
		    <div class="col-md-8 banner-sec"></div>
	    </div>
    </div>
</section>
@endsection
