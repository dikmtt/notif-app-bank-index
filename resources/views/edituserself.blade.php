@extends('dashboard-side')

@section('content')
    <div class="container"><br>
        <div class="col-md-6 col-md-offset-3">
            <h2 class="text-center">EDIT USER</h3>
            <hr>
            @if(session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
            @endif
            <form action="{{route('updateself')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{$user->id}}">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{$user->email}}" class="form-control" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="name" value="{{$user->name}}" class="form-control" placeholder="Username" required="">
                </div>
                <div class="form-group">
                    <label>Bio</label>
                    <textarea type="text" cols="5" name="bio" value="{{$user->bio}}" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label>Profile picture</label>
                    <input type="file" name="profile_picture">
                </div>
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Submit</button>
                <hr>
                <!--<p class="text-center">Already have an account? <a href="/">Login</a></p>-->
            </form>
        </div>
    </div>
@endsection