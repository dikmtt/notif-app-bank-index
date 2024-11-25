@extends('dashboard-side')

@section('content')
@if(session('error'))
            <div class="alert alert-danger">
                <b>Error:</b> {{session('error')}}
            </div>
@endif
<h1>List of Users</h1>
<a class="btn btn-success" href="{{route('newuseradmin')}}"><i class="fa fa-plus"></i> New User</a>
<hr>
  <table class="table table-bordered tabel-hover">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Peran</th>
            <th>Aktif?</th>
            <th>Aksi</th>
        </tr>
    </thead>
    @foreach($user as $u)
    <tr>
        <th>{{$u->id}}</th>
        <th>{{$u->name}}</th>
        <th>{{$u->email}}</th>
        <th>{{$u->role}}</th>
        @if($u->active == 1)
        <th>Y</th>
        @else
        <th>N</th>
        @endif
        <th>
            <a href="/userlist/edit/{{$u->id}}" class="btn btn-warning btn-sm">
                <i class="fa fa-pencil"></i></a>
            <a href="/userlist/del/{{$u->id}}" 
            onclick="return confirm('Apakah Anda Yakin Menghapus Data?');" class="btn btn-danger btn-sm">
                <i class="fa fa-trash"></i></a>
            @if($u->active == 1)
            <a href="/userlist/ban/{{$u->id}}" class="btn btn-danger btn-sm">
                <i class="fa fa-ban"></i></a>
            @else
            <a href="/userlist/unban/{{$u->id}}" class="btn btn-success btn-sm">
                <i class="fa fa-ban"></i></a>
            @endif
        </th>
    </tr>
    @endforeach
  </table>
@endsection