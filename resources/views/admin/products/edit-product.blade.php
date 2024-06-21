@extends('layouts.admin')

@section('styles')
@endsection

@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit_product') }}
                </div>

                <div class="card-body">
                    <div class="col-lg-6">
                        @if(session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="{{route("admin.update.product",$pid)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">{{ trans('global.product_name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$product->name}}" required>
                            </div>
                            <div class="form-group">
                                <label for="product_sku_id">{{ trans('global.product_sku') }}</label>
                                <select class="form-control" id="product_sku_id" name="product_sku_id" required>
                                    @foreach ($productSkus as $productSku)
                                    <option value="{{$productSku->id}}" @if($product->product_sku_id == $productSku->id) selected @endif>{{$productSku->report_full_name}} ({{$productSku->sku}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="is_active">{{ trans('global.status') }}</label>
                                <select class="form-control" id="is_active" name="is_active" required>
                                    <option value="1" @if($product->is_active == 1) selected @endif>{{ trans('global.yes') }}</option>
                                    <option value="0" @if($product->is_active == 0) selected @endif>{{ trans('global.no') }}</option>
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
