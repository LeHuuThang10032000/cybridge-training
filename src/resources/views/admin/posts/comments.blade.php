@foreach($comments as $comment)
<div class="m-2">
    <div id="section-{{ $comment->id }}" class="bg-light p-2">
        @if($comment->user)
        <strong>{{$comment->user->name}}</strong>
        @else
        <strong>Một người dùng nào đó đã phán</strong>
        @endif

        @if($comment->deleted_at !== null)
            <p>This comment has been remove</p>
        @else
        {!! $comment->content !!}
        <div class="d-flex">
            <div>
                <a style="margin-right: 1rem;" data-bs-toggle="collapse" href="#store_comment_{{ $comment->id }}" aria-expanded="false" aria-controls="store_comment_{{ $comment->id }}">
                    Reply
                </a>
                <a style="margin-right: 1rem;" data-bs-toggle="collapse" href="#edit_comment_{{ $comment->id }}" aria-expanded="false" aria-controls="edit_comment_{{ $comment->id }}">
                    Edit
                </a>
            </div>
            <div>
                <form class="mb-0" method="POST" action="{{ route('admin.comments.destroy', $comment->id) }}" onSubmit="return confirm('Are you want to delete this comment?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link text-danger p-0">Delete</button>
                </form>
            </div>
        </div>


        <div class="collapse" id="store_comment_{{ $comment->id }}">
            <form action="{{ route('admin.comments.store') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $comment->id }}" name="parent_id">
                <input type="hidden" value="{{ $post->id }}" name="post_id">
                <x-forms.ckeditor content="{{ old('content', '') }}" />
                @if($errors->has('content'))
                <div class="text-danger">{{ $errors->first('content') }}</div>
                @endif
                <button type="submit" class="btn btn-primary mt-1">Submit</button>
            </form>
        </div>

        <div class="collapse" id="edit_comment_{{ $comment->id }}">
            <form action="{{ route('admin.comments.update', $comment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" value="{{ $comment->id }}" name="parent_id">
                <input type="hidden" value="{{ $post->id }}" name="post_id">
                <x-forms.ckeditor content="{{ old('content', $comment->content) }}" />
                @if($errors->has('content'))
                <div class="text-danger">{{ $errors->first('content') }}</div>
                @endif
                <button type="submit" class="btn btn-primary mt-1">Edit</button>
            </form>
        </div>
            
        @endif
    </div>
    @include('admin.posts.comments', ['comments' => $comment->replies])
</div>
@endforeach