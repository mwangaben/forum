@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create A Thread</div>

                <div class="panel-body">
                    <form method="POST" action="/threads">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" name="title" id="title" class="form-control">
                        </div>
                        <div class="form-group">
                          <textarea name="body" id="body"  class="form-control" rows="5"></textarea>   
                        </div>
                        <button  type="submit" class="btn btn-primary">Post</button>
 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection