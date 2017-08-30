@extends('layouts.login')

@section('content')
    <div class="middle-box text-center loginscreen">
        <div>
            <h3>Welcome to</h3>
            <div>
                <h1 class="logo-name">{{env('APP_NAME')}}</h1>
            </div>
            <br/>
            <p>
                Login in. To see it in action.
            </p>
            <form class="m-t" role="form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required
                           autofocus placeholder="Email">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" type="password" class="form-control" name="password" required
                           placeholder="Password">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            Remember Me
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
                <a href="{{ route('password.request') }}" id="forgot_password">
                    <small>Forgot Your Password?</small>
                </a>
            </form>
        </div>
    </div>
@endsection
