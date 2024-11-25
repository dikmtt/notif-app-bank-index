@extends('dashboard-side')

@section('content')
<table  class="table table-bordered tabel-hover">
    <tr>
      <th>
        <h2><a class="btn btn-info btn-lg btn-block" href='sendmessage'><i class="fa fa-external-link fa-4x"></i><br>Send notification to all subscribers</a></h2>
      </th>
      <th>
        <h2><a class="btn btn-warning btn-lg btn-block" href='sendmessage2'><i class="fa fa-external-link fa-4x"></i><br>Send notification to certain subscribers</a></h2>
      </th>
    </tr>
  </table>
@endsection