@extends('layouts.app')
@extends('admin.layouts.navbar')

@section('title', 'Rules Create')

@section('content')

<div class="mx-auto" style="padding: 5px; width: 50%">
    <form action="{{ route('admin.rules.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Name</label>
            <input type="text" class="form-control" name="name">
            @if($errors->has('name'))
            <div class="text-danger">{{ $errors->first('name') }}</div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>

@endsection