@extends('layouts.app')

@section('content')
    <input type="hidden" id="agent_id" value="{{$id}}">
    <div class="content">
        <table id="admin_agent_ticket_list" style="width:100%; margin-top: 250px important!">
            <thead>
            <tr>
                <th>Ticket ID</th>
                <th>Email</th>
                <th>Title</th>
                <th>Status</th>
                <th>Action</th>
                <th>Created At</th>
            </tr>
            </thead>
        </table>
    </div>
@endsection

