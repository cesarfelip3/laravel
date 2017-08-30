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
                Perfectly designed and precisely prepared to manage your project.
            </p>
            @if(!$isValid)
                <div class="alert alert-danger">
                    <strong>Sorry!</strong> This invite isn't valid anymore.
                </div>
            @else
                <div class="alert alert-success">
                    Thank you to accept our invitation. Enter your password to begin.
                </div>
                <form class="m-t" role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="invitation_token" value="{{ $token }}" />

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password" type="password" class="form-control" name="password" required
                               placeholder="Password">

                        @if ($errors->has('password'))
                            <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <input id="password_confirmation" type="password"
                               class="form-control" name="password_confirmation" required
                               placeholder="Confirm your password">

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary block full-width m-b">
                        Register
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
