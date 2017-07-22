@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create A Thread</div>

                <div class="panel-body">
                  @if (count($errors))
                      <ul class="alert alert-danger">
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  @endif
                    <form method="POST" action="/threads">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="channel_id">Choose A Channel</label>
                            <select name="channel_id" id="channel_id" class="form-control" required>
                                    <option value="">Choose One...</option>
                                @foreach ($channels as $channel)
                                    <option value="{{ $channel->id }}"
                                     {{ old('channel_id') == $channel->id ? 'selected' : '' }}
                                     >{{ $channel->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                        </div>
                        <div class="form-group">
                          <textarea name="body" id="body"  class="form-control" rows="5"
                            required >{{ old('body') }}</textarea>   
                        </div>
                        <button  type="submit" class="btn btn-primary">Post</button>
 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection