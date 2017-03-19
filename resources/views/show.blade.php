@extends('layouts.app')

@section('content')
<div class="container">
 @if(Session::has('flash_message'))
                        <div class="alert alert-success">
                            {{ Session::get('flash_message') }}
                        </div>
                    @endif
   
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
           <h1>{{ $holiday->name }}</h1>
<p class="lead">{{ $holiday->summary }}</p>
<hr>

<a href="{{ route('holiday.index') }}" class="btn btn-info">Back to all</a>
<a href="{{ route('holiday.edit', $holiday->id) }}" class="btn btn-primary">Edit</a>

<div class="pull-right">
    <a href="#" class="btn btn-danger">Delete this</a>
</div>
        </div>
    </div>
</div>
@endsection
