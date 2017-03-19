@extends('layouts.app')

@section('content')
<div class="container">
 @if(Session::has('flash_message'))
                        <div class="alert alert-success">
                            {{ Session::get('flash_message') }}
                        </div>
                    @endif
    <div class="row">
        <div class="col-md-8 col-md-offset-2 text-right">
           <a href="{{route('holiday.create')}}" class="btn btn-success">Add New</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @foreach($holidays as $holiday)
                <h3>{{ $holiday->name }}</h3>
                <p>{{ $holiday->summary}}</p>
                <p>
                    <a href="{{ route('holiday.show', $holiday->id) }}" class="btn btn-info">View</a>
                    <a href="{{ route('holiday.edit', $holiday->id) }}" class="btn btn-primary">Edit</a>
                     
                </p>
                <hr>
            @endforeach
        </div>
    </div>
</div>
@endsection
