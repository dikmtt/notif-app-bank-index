@extends('dashboard-side')

@section('content')
<h3>Send a Notification</h3>
<form action="{{ route('sendmessagep') }}" method="post">
    @csrf
    <input hidden name="send_to" value="all">
    <div class="row">
        <div class="form-group col">
            <label>Channel type:</label> <br>
            <table class="table">
                <tr>
                    <th>
                    <input type="radio" id="telegram" name="channel" value="telegram">
                    <label for="telegram">Telegram</label>
                    </th>
                    <th>
                    <input type="radio" id="email" name="channel" value="email">
                    <label for="email">Email</label>
                    </th>
                </tr>
            </table>
        </div>
        <div class="form-group col">
            <label>Category:</label> <br>
            <table class="table">
                <tr>
                    <th>
                    <input type="radio" id="green" name="category" value="green">
                    <label for="green">Green (Normal) Alert</label>
                    </th>
                    <th>
                    <input type="radio" id="red" name="category" value="red">
                    <label for="red">Red Alert</label>
                    </th>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="form-group col">
            <label>Choose a message to send to all subscribers:</label>
            <select name="message" class="form-control">
                @foreach($mess as $m)
                    <option value={{$m->id}}>{{$m->subject}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col">
            <label>Scheduled at:</label>
            <input class="form-control" type="datetime-local" id="scheduled" name="scheduled">
        </div>
    </div>
    <div class="form-group">
        <label>Is Recurring?</label> <br>
        <table class="table">
            <tr>
                <th>
                <input type="radio" id="recur_y" name="recur" value="1" data-toggle="collapse" data-target=".collapseInt:not(.show)">
                <label for="recur_y">Yes</label>
                </th>
                <th>
                <input type="radio" id="recur_n" name="recur" value="0"  data-toggle="collapse" data-target=".collapseInt.show">
                <label for="recur_n">No</label>
                </th>
            </tr>
        </table>
    </div>
    <div class="collapseInt form-group collapse row">
        <label class="col">No. of messages to send:</label>
        <input class="col form-control" type="number" name="interval" min="0" max="10">
    </div>
    <div class="collapseInt form-group collapse row">
        <label class="col">Send message every _ minutes:</label>
        <input class="col form-control" type="number" name="duration" min="1" max="10">
    </div>
    <!--<div class="form-group">
        <label>Is Response?</label> <br>
        <table class="table">
            <tr>
                <th>
                <input type="radio" id="resp_y" name="resp" value="1">
                <label for="resp_y">Yes</label>
                </th>
                <th>
                <input type="radio" id="resp_n" name="resp" value="0">
                <label for="resp_n">No</label>
                </th>
            </tr>
        </table>
    </div>-->
    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Submit</button>
</form>
@endsection