@extends('layouts.app')

@section('content')
    <div class="content">
        @php
            $agents = \App\Agents::with("agentTickets")->get();
        @endphp
            <table id="agent_list" style="width:100%; margin-top: 250px important!">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Tickets</th>
                        <th>Created At</th>
                    </tr>
                    </thead>
            </table>
            </div>
@endsection

