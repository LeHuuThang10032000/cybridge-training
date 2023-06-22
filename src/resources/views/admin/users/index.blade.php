@extends('layouts.app')
@extends('admin.layouts.navbar')

@section('title', 'Users')

@section('content')

<div class="mx-auto" style="padding: 5px; width: 50%">
    <div class="d-flex my-1">
        <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Import
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('admin.users.export', ['type' => 'xlsx']) }}">xlsx</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.users.export', ['type' => 'csv']) }}">csv</a></li>
        </ul>
        <button type="button" class="btn btn-warning mx-2" data-bs-toggle="modal" data-bs-target="#import">Export</button>

        <div class="modal fade" id="import" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">

            <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <input type="file" class="form-control" name="user_file" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Import</button>
                            <button type="button" class="btn btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="table">
        <thead style="background-color: #08C;">
            <tr>
                <th scope="col" class="text-white">id</th>
                <th scope="col" class="text-white">Name</th>
                <th scope="col" class="text-white">Email</th>
                <th scope="col" class="text-white">Created At</th>
                <th scope="col" class="text-white">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <th scope="row">{{$user->id}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->created_at}}</td>
                <td><a class="btn btn-link mx-1" href="{{ route('admin.users.edit', $user->id) }}">Edit</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection