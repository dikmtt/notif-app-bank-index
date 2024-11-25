@extends('dashboard-side')

@section('content')
<div class="row">
    <div class="col-sm-2">
        <img class="img-fluid rounded-circle" src="{{asset(Auth::user()->profile_picture)}}">
    </div>
    <div class="col-sm-10">
        <h3><b>{{Auth::user()->name}}</b></h3>
        <h5>{{Auth::user()->email}}</h5>
        <p>{{Auth::user()->role}} | Became a member {{Auth::user()->created_at->format('Y-m-d')}}</p>
        <hr>
        <p>{{Auth::user()->bio}}</p>
    </div>
</div>
@endsection