@extends('layouts.user')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-12 pt-2 pb-2">
                <div class="row">
                    <div class="col-3">&nbsp;</div>
                    <div class="col-6">
                        <div class="h3 text-center">Payment Page</div>
                    </div>
                    <div class="col-3">&nbsp;</div>
                </div>
            </div>

            <div class="col-12 pb-0">
                <div class="row">
                    <div class="col-3">&nbsp;</div>
                    <div class="col-6">
                        <div class="h4 text-center">Order ID: #{{str_pad($orderId, 5, '0', STR_PAD_LEFT)}}. Ref ID: {{$refId}}.</div>
                        <div class="h4 text-center"></div>
                        <div class="h4 text-center">Amount: <b>{{number_format($sum/100,2)}} USD</b></div>
                        <div class="h4 text-center">Tax: <b>{{number_format($tax/100,2)}} USD</b></div>
                        <div class="h4 text-center">Grand Total: <b>{{number_format($amount/100,2)}} USD</b></div>
                    </div>
                    <div class="col-3">&nbsp;</div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-4">&nbsp;</div>
                    <div class="col-4 text-center">
                        <div class="pt-3 pb-3">
                            <div class="form-group text-start">
                                <label for="credit_card" class="col-form-label">Credit Card</label>
                                <input type="text" class="form-control" id="credit_card" name="credit_card" placeholder="Credit Card" value='4321432143214321' required />
                            </div>
                            <div class="form-group row">
                                <div class="col-6 text-start">
                                    <label for="expiry_date" class="col-form-label">Expiry Date</label>
                                    <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="Expiry Date" value='12/30' required />
                                </div>
                                <div class="col-6 text-start">
                                    <label for="ccv" class="col-form-label">CCV</label>
                                    <input type="text" class="form-control" id="ccv" name="ccv" placeholder="CCV" value='333' required />
                                </div>
                            </div>
                        </div>
                        <div class="pt-0 pb-0">
                            <button class="btn btn-primary btn-lg active" onclick="window.location.href = '{{ route('purchase.return') }}';">Pay Now</button>
                        </div>
                    </div>
                    <div class="col-4">&nbsp;</div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('custom-scripts')
@endsection
