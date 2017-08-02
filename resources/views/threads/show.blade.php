@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>
                        {{ $thread->title }}
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        @foreach ($replies as $reply)
        @include('replies.reply');
        @endforeach
        {{ $replies->links() }}

        @if (auth()->check())
            <form action="{{ $thread->path(). '/replies' }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea class="form-control" id="body" name="body" placeholder="Add a reply" rows="5">
                    </textarea>
                </div>
                <button class="btn btn-primary" type="submit">
                    Post
                </button>
            </form>
            @else
            <p class="text-center">
                Please
                <a href="{{ route('login') }}">
                    sign in
                </a>
                to participate in this discussion
            </p>
            @endif
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>
                        This Thread was created  {{ $thread->created_at->diffForHumans() }}
                by
                        <a href="">
                            {{ $thread->creator->name }}
                        </a>
                        and currently has 
                {{ $thread->replies_count }}
               {{ str_plural('comment', $thread->replies_count) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
