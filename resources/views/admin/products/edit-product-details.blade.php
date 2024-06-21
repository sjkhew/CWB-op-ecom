@extends('layouts.admin')

@section('styles')
@endsection

@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit_product_details') }}
                </div>

                <div class="card-body">
                    <div class="col-lg-6">
                        @if(session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="{{route("admin.update.product.details",$pdid)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">{{ trans('global.product_name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$productDetails->product->name}}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="desc">{{ trans('global.description') }}</label>
                                <input type="text" class="form-control" id="desc" name="desc" value="{{$productDetails->desc}}" required>
                            </div>
                            <div class="form-group">
                                <label for="qty">{{ trans('global.quantity') }}</label>
                                <input type="text" class="form-control" id="qty" name="qty" value="{{$productDetails->qty}}" required>
                            </div>
                            <div class="form-group">
                                <label for="price">{{ trans('global.price_include_vat') }}</label>
                                <input type="text" class="form-control" id="price" name="price" value="{{number_format($productDetails->price, 2, '.', '')}}" required>
                            </div>
                            <div class="form-group">
                                <label for="is_active">{{ trans('global.status') }}</label>
                                <select class="form-control" id="is_active" name="is_active" required>
                                    <option value="1" @if($productDetails->is_active == 1) selected @endif>{{ trans('global.yes') }}</option>
                                    <option value="0" @if($productDetails->is_active == 0) selected @endif>{{ trans('global.no') }}</option>
                                </select>
                            </div>
                            <a href="{{route("admin.manage.product.details",$productDetails->product->id)}}" class="btn btn-danger">{{ trans('global.back') }}</a>
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
