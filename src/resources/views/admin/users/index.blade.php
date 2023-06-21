@extends('layouts.app')
@extends('admin.layouts.navbar')

@section('title', 'Users')

@section('content')

<div class="mx-auto" style="padding: 5px; width: 50%">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <th scope="row">{{$user->id}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->created_at}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection