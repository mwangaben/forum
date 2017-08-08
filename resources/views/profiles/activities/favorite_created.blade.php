@component('profiles.activities.activity')
@slot('heading')
		                {{ $profiles->name }} favorited a reply on thread
<a href="{{ $activity->subject->favorited->thread->path() }}">
    {{ $activity->subject->favorited->thread->title }}
</a>
@endslot
@slot('body')
       {{ $activity->subject->favorited->body }}
@endslot

@endcomponent
