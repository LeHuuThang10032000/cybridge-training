@extends('layouts.app')
@extends('layouts.navbar')

@section('title', 'Liked')

@section('content')

<div class="m-2">
    <h4>Liked posts</h5>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        @foreach($posts as $post)
        <div class="col">
            <div class="card">
                @if($post->thumbnail !== null)
                <img src="{{ $post->thumbnail->getUrl() }}" class="card-img-top" alt="...">
                @endif
                <div class="card-body">
                    <p class="fs-6 text-danger">Likes: <span id="likes_count_{{$post->id}}">{{ $post->likeCount }}</span></p>
                    <h5 class="card-title">{{$post->title}}</h5>
                    <p>Last published: {{$post->updated_at}}</p>
                    <div class="d-flex justify-content-between">
                        <a href="{{$post->url}}" class="btn btn-primary">Read detail</a>
                        <div class="align-self-center">
                            <form class="like-post mb-0" action="" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $post->id }}" name="post_id">
                                <button id="like_{{$post->id}}" type="submit" href="{{$post->url}}" class="btn btn-danger p-1" style="border-radius: 50%">
                                    <img src="{{ asset('img/white-heart.png') }}" alt="#">
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection

@push('scripts')

<script>
    $('.like-post').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var buttonId = '#like_' + formData.get('post_id');
        var countId = '#likes_count_' + formData.get('post_id');
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post({
            url: "{{ route('posts.like') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Something went wrong');
            }
        });
    });
</script>

@endpush