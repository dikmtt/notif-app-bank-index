@extends('dashboard-side')

@section('content')
@if(session('error'))
            <div class="alert alert-danger">
                <b>Error:</b> {{session('error')}}
            </div>
@endif
<h1>List of Messages</h1>
<a class="btn btn-success" href="{{route('newmessage')}}"><i class="fa fa-plus"></i> New Message</a>
<hr>
<div id="accordion" class="col">
  <div class="card">
    <div class="card-header" id="sort-Head">
      <h5 class="mb-0">
        <button class="btn btn-link btn-block" data-toggle="collapse" data-target="#collapseSort" aria-expanded="true" aria-controls="collapseSort">
          Search
        </button>
      </h5>
    </div>
    <div id="collapseSort" class="collapse" aria-labelledby="sort-Head" data-parent="#accordion">
      <div class="card-body">
        <form action="{{route('findmessage')}}" method="post">
          @csrf
          <div class="row" style="display:flex">
            <div class="col">
              <select name="search_by" class="form-control" style="margin:2px 5px">
                <option value="title">By Title</option>
                <option value="content">By Content</option>
              </select>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" name="strq">
            </div>
            <div class="col">
              <button type="submit" class="btn btn-info btn-block" style="margin:2px 5px">Search</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
  <table class="table table-bordered tabel-hover" style="margin:10px">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Aksi</th>
        </tr>
    </thead>
    @foreach($message as $m)
    <tr>
        <th>{{$m->id}}</th>
        <th>{{$m->subject}}</th>
        <th>{{$m->content}}</th>
        <th>
            <a href="/messagelist/edit/{{$m->id}}" class="btn btn-warning btn-sm">
                <i class="fa fa-pencil"></i></a>
            <a href="/messagelist/del/{{$m->id}}" 
            onclick="return confirm('Apakah Anda Yakin Menghapus Data?');" class="btn btn-danger btn-sm">
                <i class="fa fa-trash"></i></a>
        </th>
    </tr>
    @endforeach
  </table>
@endsection