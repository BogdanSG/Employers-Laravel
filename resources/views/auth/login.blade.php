@extends('layouts.layout')

@section('content')
    <div style="margin: 0 auto">

        <form method="POST" action="{{ route('login') }}" class="py-5 text-center">
            @csrf
            <img class="mb-4" src="{{asset('img/user.png')}}" alt="" width="100" height="100">
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            <input name="username" type="text" class="form-control mb-3 offset-md-3 col-md-6 {{ $errors->has('username') ? ' is-invalid' : '' }}" style="text-align:center;" placeholder="Login" required="" autofocus="">
            @if ($errors->has('username'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
            <input name="password" type="password" class="form-control mb-3 offset-md-3 col-md-6 {{ $errors->has('password') ? ' is-invalid' : '' }}" style="text-align:center;" placeholder="Password">
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            <input type="submit" class="btn btn-lg btn-primary btn-block mb-3 offset-md-3 col-md-6" value="Send">

            <p class="mt-5 mb-3 text-muted">© 2018</p>
        </form>

    </div>
@endsection