<reply :attributes="{{ $reply }}" inline-template v-cloak>
    
<div id="reply-{{ $reply->id }}" class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <h5 class="flex">
                <a href="/profiles/{{ $reply->owner->name }}">
                    {{ $reply->owner->name }}
                </a>
                said
            {{ $reply->created_at->diffForHumans() }}
            </h5>
            @if (Auth::check())
                <div>
                    <favorite :reply="{{ $reply }}"></favorite>
               </div>
            @endif
        </div>
        <div class="panel-body">

        <div v-if="editing" >
        <div class="form-group">
            <textarea class="form-control" v-model="body"></textarea>
        </div>
            <button class="btn btn-xs btn-primary" @click="update">Update</button>
            <button class="btn btn-xs btn-deafult" @click="editing = false">Cancel</button>
        </div>
        <div v-else v-text="body"></div>


        </div>
        <div class="panel-footer level">
            @can('update', $reply)
                <button class="btn btn-xs mr-1 btn-success" @click="editing = true">Edit</button>
                <button class="btn btn-danger btn-xs" @click="destroy">Delete</button>
            @endcan
        </div>
    </div>
</div>
</reply>

