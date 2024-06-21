@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.email_list_title') }}
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('status'))
                        <div class="alert alert-success" id="alert" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="post" action="{{ route('admin.update.emaillist') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            {{-- <label for="email_list_notify">{{ trans('global.email_list_title') }}</label> --}}
                            <input type="text" class="form-control" id="email_list_notify" name="email_list_notify" placeholder="Enter email" value="{{$serverDetails->email_list_notify}}" required>
                            <small id="emailHelp" class="form-text text-muted">{{ trans('global.email_list_desc') }}</small>
                        </div>
                        <input type="hidden" name="server_list_id" value="{{$serverDetails->id}}">
                        <button type="submit" class="btn btn-primary" onclick="return confirm('{{trans('global.email_list_update_ask')}}')">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent

@endsection
