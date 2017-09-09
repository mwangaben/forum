@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
        <h1>
            {{ $profiles->name }}
        </h1>
    </div>
    @forelse ($activities as  $date => $activity)
      <h3 class="page-header">{{ $date }}</h3>
         @foreach ($activity as $record)
           @include("profiles.activities.$record->type", ['activity' =>  $record] )   
         @endforeach
         @empty
         <h2>Currently there are no activities for this user</h2>
    @endforelse
            {{-- {{ $threads->links() }} --}}
</div>
@stop
