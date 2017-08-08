@component('profiles.activities.activity')

@slot('heading')
		{{ $profiles->name }} published a thread
<a href="{{ $activity->subject->path()  }}">
    {{ $activity->subject->title }}
</a>
@endslot

@slot('body')
         {{ $activity->subject->body }}
@endslot

@endcomponent
