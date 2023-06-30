@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="mx-auto" style="width: 50%;">
    <h1>Login</h1>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <x-forms.input type="email" id="exampleInputEmail1" name="email" class="form-control" />
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <x-forms.input type="password" id="exampleInputPassword1" name="password" class="form-control" />
            @if(session()->has('login_error'))
            <div class="text-danger">Incorrect email or password</div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">login</button>
    </form>
    <a href="{{ route('register') }}">Or Register</a>
</div>

@endsection