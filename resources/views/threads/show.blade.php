@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                   <h4> <a href="">
                        {{ $thread->creator->name }}  
                    </a> Posted: 
                        {{ $thread->title }} 
                    {{ $thread->created_at->diffForHumans() }}
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
                @foreach ($thread->replies as $reply)
                @include('replies.reply');
                @endforeach
        </div>
    </div>
    @if (auth()->check())
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
                <form action="{{ $thread->path(). '/replies' }}" method="POST">
                  {{ csrf_field() }}
                    <div class="form-group">
                        <textarea class="form-control"  id="body" name="body"  placeholder="Add a reply" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
        </div>
    </div>
    @else
     <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion</p>
    @endif
</div>
@endsection
