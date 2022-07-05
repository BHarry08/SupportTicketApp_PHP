@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 100px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('View Ticket') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="/create-ticket">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $ticket->title }}" required autocomplete="Title" autofocus readonly>
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="emails" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                                <div class="col-md-6">
                                    <textarea rows="10" id="description" class="form-control @error('description') is-invalid @enderror" name="description" maxlength="1000" readonly>{{ $ticket->description }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
                                <div class="col-md-6">
                                    <label class="form-control" readonly="true" >{{$ticket->TicketStatus->status}}</label>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row" style="background-color: darkgray;">
                                <label for="emails" class="col-md-3 col-form-label text-md-right"></label>
                                <label for="emails" class="col-md-4 col-form-label text-md-right">{{ __('Reply History  ') }}</label>
                                <label for="emails" class="col-md-4 col-form-label text-md-right"></label>
                            </div>
                            <hr>
                            @foreach($ticket->TicketReplies as $reply)
                                <div style="background-color: #d8eddd">
                                    <div class="form-group row">
                                        <label for="emails" class="col-md-4 col-form-label text-md-right">{{ __('Reply Description : ') }}</label>
                                        <div class="col-md-6">
                                            <label class="col-md-12 col-form-label text-md-left">{{$reply->reply_description}}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="emails" class="col-md-4 col-form-label text-md-right">{{ __('Replied On : ') }}</label>
                                        <div class="col-md-6">
                                            <label class="col-md-12 col-form-label text-md-left">{{date("D d/m/Y H:i:s",strtotime($reply->created_at))}}</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="emails" class="col-md-4 col-form-label text-md-right">{{ __('Replied By : ') }}</label>
                                        <div class="col-md-6">
                                            <label class="col-md-12 col-form-label text-md-left">{{$reply->TicketRepliesBy->name}}</label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="emails" class="col-md-4 col-form-label text-md-right">{{ __('Replied Status : ') }}</label>
                                        <div class="col-md-6">
                                            <label class="col-md-12 col-form-label text-md-left">{{$reply->TicketRepliesStatus->status}}</label>
                                        </div>
                                    </div>

                                </div>
                                <hr>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
