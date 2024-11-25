@extends('dashboard-side')

@section('content')
    <div class="container"><br>
        <div class="col-md-6 col-md-offset-3">
            <h2 class="text-center">EDIT MESSAGE</h3>
            <hr>
            @if(session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
            @endif
            @foreach($message as $m)
            <form action="{{route('updatemessage')}}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$m->id}}">
            <div class="form-group">
                <label>Title</label>
                <input type="text" name="subject" value="{{$m->subject}}" class="form-control">
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea type="text" name="content" rows="4" value="{{$m->content}}" class="form-control"></textarea>
            </div>
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Submit</button>
                <hr>
                <!--<p class="text-center">Already have an account? <a href="/">Login</a></p>-->
            </form>
            @endforeach
        </div>
    </div>
@endsection