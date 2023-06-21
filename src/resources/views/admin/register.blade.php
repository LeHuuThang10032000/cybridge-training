@extends('layouts.app')

@section('title', 'Register')

@section('content')

<div class="mx-auto" style="width: 50%;">
    <form action="{{ route('admin.register') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Name</label>
            <input type="text" class="form-control" aria-describedby="emailHelp" name="name">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <a href="{{ route('admin.login') }}">Or Login</a>
</div>

@endsection