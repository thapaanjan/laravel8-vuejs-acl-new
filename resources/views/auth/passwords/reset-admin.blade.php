@extends('layouts.auth')
@section('title')
    Reset Password
@stop
@section('content')
<div class="login-register">
    <div class="login-box card">
        <div class="card-body">
            <form method="POST" action="{{route('admin.password.request')}}">
                    @csrf
                <h3 class="text-center m-b-20">Reset Password</h3>
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus readonly>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>      
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="New Password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>      
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm New Password">
                    </div>
                </div>                 
                <div class="form-group text-center">
                    <div class="col-xs-12 p-b-20">
                        <button type="submit"class="btn btn-block btn-lg btn-info btn-rounded">Reset Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

