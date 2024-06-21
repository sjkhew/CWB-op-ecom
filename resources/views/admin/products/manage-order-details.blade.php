@extends('layouts.admin')

@section('styles')
@endsection

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        {{ trans('global.manage_order') }}
                    </div>

                    <div class="card-body">
                        <div class="form-group">

                            <div class="row pb-2">
                                <div class="col-lg-4">
                                    <h4>{{ trans('global.order_id') }}{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</h4>
                                </div>
                                <div class="col-lg-8 text-right">
                                    <a href="{{route("admin.manage.order")}}" class="btn btn-danger">{{ trans('global.back') }}</a>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-lg-3">
                                    <label for="">{{ trans('global.transaction_date') }}</label>
                                    <p class="h5">{{ $order->created_at }}</p>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ trans('global.status') }}</label>
                                    <h4>
                                        @if($order->is_paid == 1)
                                        <span class="badge badge-success">{{ trans('global.payment_status_success') }}</span>
                                        @elseif ($order->is_paid == 0)
                                        <span class="badge badge-warning">{{ trans('global.payment_status_pending') }}</span>
                                        @else
                                        <span class="badge badge-danger">{{ trans('global.payment_status_failed') }}</span>
                                        @endif
                                    </h4>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ trans('global.amount') }}</label>
                                    <p class="h5">{{ number_format($order->total_amount,2) }}</p>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ trans('global.order_ref_id') }}</label>
                                    <p class="h5">{{ $order->ref_id }}</p>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-lg-3">
                                    <label for="">{{ trans('global.payment_tax_id') }}</label>
                                    <p class="h6">{{ ($order->stripe_tax_id) ? $order->stripe_tax_id : '-' }}</p>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ trans('global.intent_id') }}</label>
                                    <p class="h6">{{ ($order->stripe_payment_intent_id) ? $order->stripe_payment_intent_id : '-' }}</p>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ trans('global.payment_method_types') }}</label>
                                    <p class="h6">{{ ($order->stripe_payment_method_types) ? strtoupper($order->stripe_payment_method_types) : '-' }}</p>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ trans('global.payment_status') }}</label>
                                    <p class="h6">{{ ($order->stripe_status) ? strtoupper($order->stripe_status) : '-' }}</p>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-lg-12">
                                    <span class="hr"><hr /></span>
                                </div>
                            </div>

                            {{-- Customer Details --}}
                            <div class="row pb-2">
                                <div class="col-lg-12">
                                    <div class="h4">{{ trans('global.customer_details') }}</div>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-lg-3">
                                    <label for="">{{ trans('global.login_email') }}</label>
                                    <p class="h5">{{ $order->customer->email }}</p>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ trans('global.name') }}</label>
                                    <p class="h5">{{ $order->customer->first_name.' '.$order->customer->last_name }}</p>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ trans('global.tax_id') }}</label>
                                    <p class="h5">{{ $order->customer->tax_id ? : '-' }}</p>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ trans('global.member_id') }}</label>
                                    <p class="h5">{{ $order->customer->member_id }}</p>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-lg-3">
                                    <label for="">{{ trans('global.address') }}</label>
                                    <p class="h5">{{ $order->customer->address1 }}</p>
                                </div>
                                <div class="col-lg-2">
                                    <label for="">{{ trans('global.suburb') }}</label>
                                    <p class="h5">{{ $order->customer->suburb }}</p>
                                </div>
                                <div class="col-lg-2">
                                    <label for="">{{ trans('global.state') }}</label>
                                    <p class="h5">{{ $order->customer->state }}</p>
                                </div>
                                <div class="col-lg-2">
                                    <label for="">{{ trans('global.postcode') }}</label>
                                    <p class="h5">{{ $order->customer->postcode }}</p>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ trans('global.country') }}</label>
                                    <p class="h5">{{ $order->customer->country }}</p>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-lg-12">
                                    <span class="hr"><hr /></span>
                                </div>
                            </div>

                            {{-- Order Details --}}
                            <div class="row pb-2">
                                <div class="col-lg-12">
                                    <div class="h4">{{ trans('global.order_details') }}</div>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-lg-12">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ trans('global.product_name') }}</th>
                                                <th>{{ trans('global.quantity') }}</th>
                                                <th class="text-right">{{ trans('global.price') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $xSum = 0; @endphp
                                            @foreach ($order->orderDetails as $orderDetail)
                                                <tr>
                                                    <td>{{ $orderDetail->productDetail->desc }}</td>
                                                    <td>{{ $qty = 1 }}</td>
                                                    <td class="text-right">{{ number_format($qty * $orderDetail->price,2) }}</td>
                                                </tr>
                                                @php $xSum += $qty * $orderDetail->price; @endphp
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-right" colspan="2">{{ trans('global.total_amount') }}</td>
                                                <td class="text-right">{{ number_format($xSum,2) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-right" colspan="2">{{ trans('global.tax') }} ({{number_format($order->tax_amount * 100 / $xSum,2)}}&percnt;)</td>
                                                <td class="text-right">{{ number_format($order->tax_amount,2) }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-right" colspan="2">{{ trans('global.grand_total') }}</th>
                                                <th class="text-right">{{ number_format($xSum + $order->tax_amount,2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            {{-- Invoices --}}
                            <div class="row pb-2">
                                <div class="col-lg-12">
                                    <div class="h4">{{ trans('global.invoice') }}</div>
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-lg-12 text-left">
                                    @if($order->is_paid == 1)
                                    <a href="{{route('admin.export.invoice',$order->id)}}" class="btn btn-primary"><i class="fas fa-receipt"></i> {{ trans('global.downloadFile') }}</a>
                                    @else
                                    <a class="btn btn-secondary disabled"><i class="fas fa-receipt"></i> {{ trans('global.downloadFile') }}</a>
                                    @endif
                                </div>
                            </div>
                            <div class="row pb-2">
                                <div class="col-lg-12 text-right">
                                    <a href="{{route("admin.manage.order")}}" class="btn btn-danger">{{ trans('global.back') }}</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
