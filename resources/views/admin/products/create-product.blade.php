@extends('layouts.admin')

@section('styles')
@endsection

@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.add_product') }}
                </div>

                <div class="card-body">
                    <div class="col-lg-6">
                        @if(session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="{{route("admin.store.product")}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">{{ trans('global.product_name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{old('name', '')}}" required>
                            </div>
                            <div class="form-group">
                                <label for="product_sku_id">{{ trans('global.product_sku') }}</label>
                                <select class="form-control" id="product_sku_id" name="product_sku_id" required>
                                    <option value="">{{ trans('global.pleaseSelect') }}</option>
                                    @foreach ($productSkus as $productSku)
                                    <option value="{{$productSku->id}}">{{$productSku->report_full_name}} ({{$productSku->sku}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="is_active">{{ trans('global.status') }}</label>
                                <select class="form-control" id="is_active" name="is_active" required>
                                    <option value="1" selected>{{ trans('global.yes') }}</option>
                                    <option value="0">{{ trans('global.no') }}</option>
                                </select>
                            </div>
                            <a href="{{route("admin.manage.product")}}" class="btn btn-danger">{{ trans('global.back') }}</a>
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
@endsection
