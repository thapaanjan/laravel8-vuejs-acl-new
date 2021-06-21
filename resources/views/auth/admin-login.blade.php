@extends('layouts.auth')
@section('title')
    Login
@stop
@section('content')
<div class="login-register">
    <div class="login-box card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <h3 class="text-center m-b-20">Sign In</h3>
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="******">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="d-flex no-block align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                            <div class="ml-auto">
                                <a href="{{route('admin.password.request')}}" id="to-recover" class="text-muted"><i class="fas fa-lock m-r-5"></i> Forgot Password?</a> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <div class="col-xs-12 p-b-20">
                        <button type="submit"class="btn btn-block btn-lg btn-info btn-rounded">Sign In</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection