@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.server_status') }}
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" id="alert" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="post" action="{{ route('admin.update.status') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Server Name</th>
                                    <th>Service Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($serverLists as $serverList)
                                <tr>
                                    <td>{{ $serverList->getServerName->name }}</td>
                                    <td>{{ $serverList->getServiceName->name }}</td>
                                    <td>
                                        <select class="custom-select" name="{{'data-id_'.$serverList->id}}">
                                            <option value="1" @if($serverList->server_status == 1) selected @endif>{{ trans('global.service_up_title') }}</option>
                                            <option value="0" @if($serverList->server_status == 0) selected @endif>{{ trans('global.service_busy_title') }}</option>
                                            <option value="2" @if($serverList->server_status == 2) selected @endif>{{ trans('global.service_maintenance_title') }}</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="text-right">
                                    <td colspan="3"><button type="submit" class="btn btn-primary" onclick="return confirm('{{trans('global.server_status_update_ask')}}')">Set Status</button></td>
                                </tr>
                            </tfoot>
                        </table>
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
