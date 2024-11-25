@extends('dashboard-side')

@section('content')
  <h4>Selamat Datang <b>{{Auth::user()->name}}</b>, Anda Login sebagai <b>{{Auth::user()->role}}</b>.</h4>

  @if(Auth::user()->role == "admin")
  <table  class="table table-bordered tabel-hover">
    <tr>
      <th>
        <h2><a class="btn btn-warning btn-lg btn-block" href='userlist'><i class="fa fa-user fa-4x"></i><br>View users</a></h2>
      </th>
      <th>
        <h2><a class="btn btn-primary btn-lg btn-block" href='subslist'><i class="fa fa-bell fa-4x"></i><br>View subscribers</a></h2>
      </th>
      <th>
        <h2><a class="btn btn-success btn-lg btn-block" href='messagelist'><i class="fa fa-envelope fa-4x"></i><br>View messages</a></h2>
      </th>
    </tr>
    <tr>
      <th>
        <h2><a class="btn btn-info btn-lg btn-block" href='sendmenu'><i class="fa fa-external-link fa-4x"></i><br>Send notification</a></h2>
      </th>
      <th>
        <h2><a class="btn btn-danger btn-lg btn-block" href='querylist'><i class="fa fa-search fa-4x"></i><br>View queries</a></h2>
      </th>
      <th>
      <h2><a class="btn btn-secondary btn-lg btn-block" href='notifhistory'><i class="fa fa-history fa-4x"></i><br>History</a></h2>
      </th>
    </tr>
  </table>
  @endif
@endsection