@extends('layouts.auth')
@section('title')
    Forgot Password
@stop
@section('content')
<div class="login-register">
    <div class="login-box card">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert" >
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form method="POST" action="{{route('admin.password.email')}}">
                @csrf
                <h3 class="text-center m-b-20">Forgot Password</h3>
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
                <div class="form-group text-center">
                    <div class="col-xs-12 p-b-20">
                        <button type="submit"class="btn btn-block btn-lg btn-info btn-rounded">Send Reset Link</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection