@extends('layouts.app')

@section('content')
<thread-view inline-template :initial-replies-count="{{ $thread->replies_count }}">
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                <div class="level">
                    <h4 class="flex">
                        {{ $thread->title }}
                    </h4>
                    @can ('update', $thread)
                    <form method="POST" action="{{ $thread->path() }}">
                       {{ csrf_field() }}
            
                       {{ method_field('DELETE') }}
                     <button class="btn btn-default delete" type="submit" >Delete Thread</button>   
                       
                    </form>
                    @endcan
                </div>
                </div>
                <div class="panel-body">
                    <div class="body">
                        {{ $thread->body }}
                    </div>
                    
                </div>
            </div>


            <replies 
                @created="repliesCount++" 
                @removed="repliesCount--"> 
            </replies>

        
        {{-- {{ $replies->links() }}  --}}


        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>
                        This Thread was created  {{ $thread->created_at->diffForHumans() }}
                by
                        <a href="/profiles/{{ $thread->creator->name }}">
                            {{ $thread->creator->name }}
                        </a>
                        and currently has 
                <span v-text="repliesCount"></span>
               {{ str_plural('comment', $thread->replies_count) }}
                    </p>

                    <p>
                        <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</thread-view>
@endsection
