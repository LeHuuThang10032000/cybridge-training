@extends('layouts.app')
@extends('admin.layouts.navbar')

@section('title', 'Users Edit')

@section('content')

<div class="mx-auto" style="padding: 5px; width: 50%">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{old('title', $user->name)}}">
            @if($errors->has('name'))
            <div class="text-danger">{{ $errors->first('name') }}</div>
            @endif
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="text" class="form-control" name="email" value="{{old('url', $user->email)}}">
            @if($errors->has('url'))
            <div class="text-danger">{{ $errors->first('email') }}</div>
            @endif
        </div>
        
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Rules:</label>
            <select name="permissions[]" id="permission" required multiple=true class="js-example-basic-multiple form-control" style="width: 100%">
            @foreach($rules as $rule)
            <option value="{{ $rule->id }}" {{ $user->hasPermissionTo($rule->name) ? 'selected="selected"' : '' }}>
                {{ $rule->name }}
            </option>
            @endforeach
        </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    })
</script>
@endpush