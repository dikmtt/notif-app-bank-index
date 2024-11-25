@extends('dashboard-side')

@section('content')
<div class="container"><br>
        <div class="col-md-6 col-md-offset-3">
            <h2 class="text-center">New Query</h3>
            <hr>
            <form action="{{route('savequery')}}" method="post">
            @csrf
                <div class="form-group">
                    <label>Subject String:</label>
                    <input type="text" name="string" class="form-control" placeholder="String" required="">
                </div>
                <div class="form-group">
                    <label>Target Subscriber:</label>
                    <select name="target" class="form-control">
                        @foreach($subs as $u)
                        <option value="{{$u->subscriber_id}}">{{$u->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Submit</button>
                <hr>
            </form>
        </div>
    </div>
@endsection