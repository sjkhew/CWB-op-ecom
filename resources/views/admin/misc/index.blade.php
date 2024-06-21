@extends('layouts.admin')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.misc') }}
                </div>

                <div class="card-body">
                    <div class="col-lg-6">
                        @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <form action="{{route("admin.update.misc")}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{ trans('global.postal_resend_charges') }}</label>
                                <input type="text" class="form-control" id="postal_resend_charges" name="postal_resend_charges" value="{{ number_format($misc->postal_resend_charges,2)}}" required>
                            </div>
                            <button type="submit" class="btn btn-success mx-1">{{ trans('global.submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
@endsection
