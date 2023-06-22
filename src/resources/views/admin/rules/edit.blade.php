@extends('layouts.app')
@extends('admin.layouts.navbar')

@section('title', 'Rule Edit')

@section('content')

<div class="mx-auto" style="padding: 5px; width: 50%">
    <form action="{{ route('admin.rules.update', $rule->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{old('name', $rule->name)}}">
            @if($errors->has('name'))
            <div class="text-danger">{{ $errors->first('name') }}</div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

@endsection