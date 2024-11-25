@extends('dashboard-side')

@section('content')
<div class="container"><br>
        <div class="col-md-6 col-md-offset-3">
            <h2 class="text-center">Register subscriber email</h3>
            <hr>
            @if(session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
            @endif
            @foreach($subscriber as $s)
            <form action="{{route('registeremailproc')}}" method="post">
            @csrf
            <input type="hidden" name="sub_id" value="{{$s->subscriber_id}}">
                <div class="form-group">
                    <label>Name</label>
                    <input disabled value="{{$s->name}}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email" required="">
                </div>
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Submit</button>
                <hr>
                <!--<p class="text-center">Already have an account? <a href="/">Login</a></p>-->
            </form>
            @endforeach
        </div>
    </div>
@endsection