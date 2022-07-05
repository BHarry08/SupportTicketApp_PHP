@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 100px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Add Reply') }}</div>

                    <div class="card-body">
                        <form method="POST" action="/add-reply/{{$ticket->id}}">
                            @csrf
                            <input type="hidden" name="id" value="{{$ticket->id}}">
                            <div class="form-group row">
                                <label for="emails" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <textarea rows="10" id="description" class="form-control @error('description') is-invalid @enderror" name="description" maxlength="1000" required>{{ old('description') }}</textarea>
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
                                    @foreach($statuses as $status)
                                        @if($ticket->status == $status->id)
                                            <label class="form-control" readonly="true" >{{ $status->status }}</label>
                                        @endif
                                    @endforeach
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-8">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
