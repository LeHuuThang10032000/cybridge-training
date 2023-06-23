@foreach($comments as $comment)
<div class="m-2" id="comment-section={{ $comment->id }}">
    <div class="bg-light p-2">
        @if($comment->user_model == 'admins')
        <strong>{{$comment->admin->name}}</strong>
        @else
        <strong>{{$comment->user->name}}</strong>
        @endif
        
        @if($comment->deleted_at !== null)
            <p>This comment has been remove</p>
        @else
        {!! $comment->content !!}

        @can('create_comment')
        <div class="d-flex">
            <div>
                <a style="margin-right: 1rem;" data-bs-toggle="collapse" href="#store_comment_{{ $comment->id }}" aria-expanded="false" aria-controls="store_comment_{{ $comment->id }}">
                    Reply
                </a>
                @if($comment->user_id == auth()->user()->id && $comment->user_model == auth()->user()->getTable())
                <a style="margin-right: 1rem;" data-bs-toggle="collapse" href="#edit_comment_{{ $comment->id }}" aria-expanded="false" aria-controls="edit_comment_{{ $comment->id }}">
                    Edit
                </a>
                @endif
            </div>
            <div>
                @if($comment->user_id == auth()->user()->id && $comment->user_model == auth()->user()->getTable())
                <form class="mb-0" method="POST" action="{{ route('comments.destroy', $comment->id) }}" onSubmit="return confirm('Are you want to delete this comment?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link text-danger p-0">Delete</button>
                </form>
                @endif
            </div>
        </div>
        @endcan

        <div class="collapse" id="store_comment_{{ $comment->id }}">
            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $comment->id }}" name="parent_id">
                <input type="hidden" value="{{ $post->id }}" name="post_id">
                <textarea class="form-control ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" id="content"></textarea>
                @if($errors->has('content'))
                <div class="text-danger">{{ $errors->first('content') }}</div>
                @endif
                <button type="submit" class="btn btn-primary mt-1">Submit</button>
            </form>
        </div>

        @if($comment->user_id == auth()->user()->id && $comment->user_model == auth()->user()->getTable())
        <div class="collapse" id="edit_comment_{{ $comment->id }}">
            <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" value="{{ $comment->id }}" name="parent_id">
                <input type="hidden" value="{{ $post->id }}" name="post_id">
                <textarea class="form-control ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" id="content">{!! $comment->content !!}</textarea>
                @if($errors->has('content'))
                <div class="text-danger">{{ $errors->first('content') }}</div>
                @endif
                <button type="submit" class="btn btn-primary mt-1">Edit</button>
            </form>
        </div>
        @endif
        @endif
    </div>
    @include('comments', ['comments' => $comment->replies])
</div>
@endforeach