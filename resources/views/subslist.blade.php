@extends('dashboard-side')

@section('content')
<h1>List of Subscribers</h1>
<hr>
<div class="row">
<div id="accordion" class="col">
  <div class="card">
    <div class="card-header" id="filter-Head">
      <h5 class="mb-0">
        <button class="btn btn-link btn-block" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">
          Filtering
        </button>
      </h5>
    </div>
    <div id="collapseFilter" class="collapse" aria-labelledby="finter-Head" data-parent="#accordion">
      <div class="card-body">
        <form action="{{route('filtersubs')}}" method="post">
          @csrf
          <div class="row" style="display:flex">
            <div class="col">
              <select name="filterby" class="form-control" style="margin:2px 5px">
                <option value="month">This Month</option>
                <option value="year">This Year</option>
                <option value="all">All Time</option>
              </select>
            </div>
            <div class="col">
              <button type="submit" class="btn btn-primary btn-block" style="margin:2px 5px">Filter</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="accordion" class="col">
  <div class="card">
    <div class="card-header" id="sort-Head">
      <h5 class="mb-0">
        <button class="btn btn-link btn-block" data-toggle="collapse" data-target="#collapseSort" aria-expanded="true" aria-controls="collapseSort">
          Sorting
        </button>
      </h5>
    </div>
    <div id="collapseSort" class="collapse" aria-labelledby="sort-Head" data-parent="#accordion">
      <div class="card-body">
        <form action="{{route('sortsubs')}}" method="post">
          @csrf
          <div class="row" style="display:flex">
            <div class="col">
              <select name="sort_what" class="form-control" style="margin:2px 5px">
                <option value="name">Name</option>
                <option value="date">Date Joined</option>
              </select>
          </div>
          <div class="col">
              <select name="sort_how" class="form-control" style="margin:2px 5px">
                <option value="asc">Ascending</option>
                <option value="desc">Descending</option>
              </select>
          </div>
            <div class="col">
              <button type="submit" class="btn btn-info btn-block" style="margin:2px 5px">Sort</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>

  

<br />
  <table class="table table-bordered tabel-hover">
    <thead class="thead-dark">
      <tr>
          <th>ID Subscriber</th>
          <th>Nama</th>
          <th>Username</th>
          <th>Email</th>
          <th>Tanggal Bergabung</th>
          <th>Aksi</th>
      </tr>
    </thead>
    @foreach($subs as $s)
    <tr>
        <th>{{$s->subscriber_id}}</th>
        <th>{{$s->name}}</th>
        @if($s->username == null)
        <th>-</th>
        @else
        <th>{{$s->username}}</th>
        @endif
        @if($s->email == null)
        <th>-</th>
        @else
        <th>{{$s->email}}</th>
        @endif
        <th>{{date('Y-m-d', strtotime($s->created_at))}}</th>
        <th>
            <a href="/registeremail/{{$s->id}}" class="btn btn-warning btn-sm">
                <i class="fa fa-envelope"></i></a>
            <a href="/subslist/del/{{$s->id}}" 
            onclick="return confirm('Apakah Anda Yakin Menghapus Data?');" class="btn btn-danger btn-sm">
                <i class="fa fa-trash"></i></a>
        </th>
    </tr>
    @endforeach
  </table>

<a href="exportexcel" class="btn btn-primary btn-block">Export</a>
@endsection