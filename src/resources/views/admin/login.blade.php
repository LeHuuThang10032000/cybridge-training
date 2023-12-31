@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="mx-auto" style="width: 50%;">
    <h1>Login</h1>
    <form action="{{ route('admin.login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password">
        </div>
        @if(session()->has('login_error'))
        <p>
            <strong>Incorrect email or password</strong>
        </p>
        @endif
        <button type="submit" class="btn btn-primary">login</button>
    </form>
    <a href="{{ route('admin.register') }}">Or Register</a>
</div>

@endsection