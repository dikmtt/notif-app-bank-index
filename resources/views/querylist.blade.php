@extends('dashboard-side')

@section('content')
<h1>List of Notification Queries</h1>
<p>Here you can set the queries so that whenever an email contains a specific string, the notification will be sent to the specified recipient instead of the email's receiver.</p>
<a class="btn btn-success" href="{{route('addsendquery')}}"><i class="fa fa-plus"></i> New Query</a>
<hr>
  <table class="table table-bordered tabel-hover">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>String to check</th>
            <th>Send to</th>
            <th>Aksi</th>
        </tr>
    </thead>
    @foreach($query as $q)
    <tr>
        <th>{{$q->id}}</th>
        <th>{{$q->querystring}}</th>
        <th>{{$q->sub->name}}</th>
        <th>
            <a href="/querylist/del/{{$q->id}}" 
            onclick="return confirm('Apakah Anda Yakin Menghapus Data?');" class="btn btn-danger btn-sm">
                <i class="fa fa-trash"></i></a>
        </th>
    </tr>
    @endforeach
  </table>
@endsection