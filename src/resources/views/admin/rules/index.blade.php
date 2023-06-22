@extends('layouts.app')
@extends('admin.layouts.navbar')

@section('title', 'Rules')

@section('content')

<div class="mx-auto" style="padding: 5px; width: 50%">
    <div class="my-2">
        <a class="btn btn-primary" href="{{ route('admin.rules.create') }}">Create</a>
    </div>
    <table class="table">
        <thead style="background-color: #08C;">
            <tr>
                <th scope="col" class="text-white">id</th>
                <th scope="col" class="text-white">name</th>
                <th scope="col" class="text-white">actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rules as $rule)
            <tr>
                <th scope="row">{{$rule->id}}</th>
                <td>{{$rule->name}}</td>
                <td>
                    <div class="d-flex">
                        <a class="btn btn-link mx-1" href="{{ route('admin.rules.edit', $rule->id) }}">Edit</a>
                        <form class="mb-0" method="POST" action="{{ route('admin.rules.destroy', $rule->id) }}" onSubmit="return confirm('Are you want to delete this rule?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection