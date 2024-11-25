@extends('dashboard-side')

@section('content')
<h3>Create New Message</h3>
<form action="{{ route('savemessage') }}" method="post">
    @csrf
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control">
    </div>
    <div class="form-group">
        <label>Content</label>
        <textarea type="text" name="content" rows="4" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Submit</button>
</form>
@endsection