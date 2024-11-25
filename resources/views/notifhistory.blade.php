@extends('dashboard-side')

@section('content')
<h1>Notification History</h1>
<hr>
<div class="accordion" id="accordion">
  <div class="card">
    <div class="card-header" id="filter-Head">
      <h5 class="mb-0">
        <button class="btn btn-link btn-block" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="true" aria-controls="collapseFilter">
          Filter
        </button>
      </h5>
    </div>
    <div id="collapseFilter" class="collapse" aria-labelledby="filter-Head" data-parent="#accordion">
      <div class="card-body">
        <form action="{{route('filternotifs')}}" method="get">
            @csrf
            <div class="row" style="display:flex">
              <div class="col">
                <label style="margin:2px 5px">Sent Time</label>
                <select name="sent_time" class="form-control" style="margin:2px 5px">
                  <option value="week" data-toggle="collapse" data-target=".collapseInt.show">This Week</option>
                  <option value="month" data-toggle="collapse" data-target=".collapseInt.show">This Month</option>
                  <option value="all" data-toggle="collapse" data-target=".collapseInt.show">All Time</option>
                  <option value="custom" data-toggle="collapse" data-target=".collapseInt:not(.show)">Custom</option>
                </select>
                <div class="collapseInt form-group collapse">
                  <label>From:</label>
                  <input class="form-control" name="startdate" type="date">
                  <label>To:</label>
                  <input class="form-control" name="enddate" type="date">
                </div>
            </div>
            <div class="col">
                <label style="margin:2px 5px">Channel</label>
                <select name="channel" class="form-control" style="margin:2px 5px">
                  <option value="all">All</option>
                  <option value="telegram">Telegram</option>
                  <option value="email">Email</option>
                </select>
            </div>
            <div class="col">
                <label style="margin:2px 5px">Type</label>
                <select name="type" class="form-control" style="margin:2px 5px">
                  <option value="all">All</option>
                  <option value="red">Red Alerts</option>
                  <option value="green">Green Alerts</option>
                </select>
            </div>
            <div class="col">
                <label style="margin:2px 5px">Is Recurring?</label>
                <select name="recur" class="form-control" style="margin:2px 5px">
                  <option value="all">All</option>
                  <option value="yes">Yes</option>
                  <option value="no">No</option>
                </select>
            </div>
          </div>
          <div>
            <button type="submit" class="btn btn-primary btn-block" style="margin:2px 5px">Filter</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
  <table class="table table-bordered tabel-hover">
    <thead class="thead-dark">
        <tr>
            <th>Message Title</th>
            <th>Sent At</th>
            <th>Type</th>
            <th>Recurring?</th>
            <th>How Sent</th>
        </tr>
    </thead>
    @foreach($notifs as $n)
    <tr>
        @if($n->category == "red") @php($col = "danger") @else @php($col = "success") @endif
        <th>{{$n->message->subject}}</th>
        <th>{{$n->sent_at}}</th>
        @if($n->channel_type == "email")
            <th><i class="fa fa-envelope fa-2x text-{{$col}}"></i></th>
        @else
            <th><i class="fa fa-telegram fa-2x text-{{$col}}"></i></th>
        @endif
        @if($n->is_recurring == "1")
            <th>Yes ({{$n->duration}})</th>
        @else
            <th>No</th>
        @endif
        <th>{{$n->how_sent}}</th>
    </tr>
    @endforeach
  </table>
    @if ($notifs->links()->paginator->hasPages())
            <div class="mt-4 p-4 box has-text-centered">
                {{ $notifs->appends(request()->query())->links() }}
            </div>
    @endif
@endsection