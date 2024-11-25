@extends('dashboard-side')

@section('content')
    <div class="container"><br>
        <div class="col-md-6 col-md-offset-3">
            <h2 class="text-center">NEW USER</h3>
            <hr>
            @if(session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
            @endif
            <form action="{{route('newuseradmin')}}" method="post">
            @csrf
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="name" class="form-control" placeholder="Username" required="">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control">
                        <option value="guest">Guest</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Submit</button>
                <hr>
                <!--<p class="text-center">Already have an account? <a href="/">Login</a></p>-->
            </form>
        </div>
    </div>
@endsection