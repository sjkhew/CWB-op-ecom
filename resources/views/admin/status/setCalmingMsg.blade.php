@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.alert_calming_msg') }}
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

                    <form method="post" action="{{ route('admin.update.calmingmsg') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            {{-- <label for="calming_msg">{{ trans('global.alert_calming_msg') }}</label> --}}
                            <input type="text" class="form-control" id="calming_msg" name="calming_msg" placeholder="Enter message" value="{{$serverDetails->calming_msg}}" required>
                            <small id="emailHelp" class="form-text text-muted">{{ trans('global.alert_calming_msg_desc') }}</small>
                        </div>
                        <input type="hidden" name="server_list_id" value="{{$serverDetails->id}}">
                        <button type="submit" class="btn btn-primary" onclick="return confirm('{{trans('global.calming_msg_update_ask')}}')">Submit</button>
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
