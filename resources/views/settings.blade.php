@extends('dashboard-side')

@section('content')
<h1>Settings</h1>
<div class="col-xl-10 col-md-8 mb-5">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="editdetails">Edit user data</a></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-wrench fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="setwebhook">Set webhook</a></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-rss fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="clearnotifhist">Clear notification history</a></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-trash fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="querylist">Manage email queries</a></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-search fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection