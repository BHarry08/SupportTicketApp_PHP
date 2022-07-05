<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Support Ticket Application</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            margin-top: 6%;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

<div class="flex-center full-height">
    @php $user = \Illuminate\Support\Facades\Auth::user() @endphp
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                @if($user->role == "user")
                    <a href="{{ url('/create-ticket') }}">Create Ticket</a>
                @endif
                <a href="{{ url('/list') }}">View Tickets</a>
                <a href="{{ url('/logout') }}">Logout</a>
            @else
                @if(\Illuminate\Support\Facades\Auth::guard('agents')->user())
                    <a href="{{ url('/agent/list') }}">View Tickets</a>
                    <a href="{{ url('/agent/logout') }}">Logout</a>
                @elseif(\Illuminate\Support\Facades\Auth::guard('admins')->user())
                    <a href="{{ url('/admin/list-agents') }}">List Agents</a>
                    <a href="{{ url('/admin/logout') }}">Logout</a>
                @else
                    <a href="{{ route('login') }}">User Login</a>
                    <a href="/agent/login">Agent Login</a>
                    <a href="/admin/login">Admin Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif

                @endif
            @endauth
        </div>
    @endif
    @yield('content')
</div>
@if(\Illuminate\Support\Facades\Session::has('message'))
    <p class="alert {{ \Illuminate\Support\Facades\Session::get('alert-class', 'alert-info') }}">{{ \Illuminate\Support\Facades\Session::get('message') }}</p>
@endif
<script>
    $(document).ready(function() {

        $('#list_agent_tickets').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "/agent/list-tickets",
            'columns': [
                { data: 'id' ,orderable: true, searchable: false},
                { data: 'user.emails',searchable: false,orderable: false},
                { data: 'title' ,orderable: true, searchable: true},
                { data: 'ticket_status.status' ,orderable: false, searchable: false},
                { data: 'created_at',orderable: true },
            ],
            columnDefs: [
                {
                    targets: 0,
                    render: function (data, type, row, meta)
                    {
                        if (type === 'display')
                        {
                            data = '<a href="/agent/view/' + encodeURIComponent(data) + '">' +data + '</a>';
                        }
                        return data;
                    }
                }],
        } );

        $('#agent_list').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "/admin/admin-list-agents",
            'columns': [
                { data: 'id' ,orderable: true},
                { data: 'name' , searchable: true},
                { data: 'emails',orderable: false },
                { data: 'phone' ,orderable: false, searchable: false},
                { data: 'id' ,orderable: false, searchable: true},
                { data: 'created_at' },
            ],
            columnDefs: [
                {
                    targets: 4,
                    render: function (data, type, row, meta)
                    {
                        if (type === 'display')
                        {
                            data = '<a href="/admin/list-agent-tickets/' + encodeURIComponent(data) + '">View</a>';
                        }
                        return data;
                    }
                }],
        } );
    } );
    var agent_id=  $("#agent_id").val();
    $('#admin_agent_ticket_list').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "/admin/list-agent-tickets-data/"+agent_id,
        'columns': [
            { data: 'id' ,orderable: true, searchable: false},
            { data: 'user.emails',searchable: false,orderable: false},
            { data: 'title' ,orderable: true, searchable: true},
            { data: 'ticket_status.status' ,orderable: false, searchable: false},
            { data: 'id',orderable: true },
            { data: 'created_at',orderable: true },
        ],
        columnDefs: [
            {
                targets: 4,
                render: function (data, type, row, meta)
                {
                    if (type === 'display')
                    {
                        data = '<a href="/admin/view/' + encodeURIComponent(data) + '">View</a>';
                    }
                    return data;
                }
            }],
    } );

    $('#user_ticket_list').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "/list-tickets",
        'columns': [
            { data: 'id' ,orderable: true, searchable: false},
            { data: 'user.emails',searchable: false,orderable: false},
            { data: 'title' ,orderable: true, searchable: true},
            { data: 'ticket_status.status' ,orderable: false, searchable: false},
            { data: 'created_at',orderable: true },
        ],
        columnDefs: [
            {
                targets: 0,
                render: function (data, type, row, meta)
                {
                    if (type === 'display')
                    {
                        data = '<a href="/agent/view/' + encodeURIComponent(data) + '">' +data + '</a>';
                    }
                    return data;
                }
            }],
    } );
</script>
</body>
</html>
