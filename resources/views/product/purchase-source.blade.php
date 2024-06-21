@extends('layouts.user')

@section('custom-styles')
@endsection

@section('content')
    @php
        $faker = Faker\Factory::create();
        $email = 'dev@cell-wellbeing.com';
        $first_name = 'Cell Wellbeing';
        $last_name = 'Dev';
        $address1 = '2624 N Main St';
        $suburb = 'Roswell';
        $state = 'New York';
        $postcode = '88201';
        $country = 'US';
        $tax_id = '900114321';
        $member_id = '8888';
        $parent_id = '4444';
        $url_id = '10';
        $allow_reports = '{"9":"09_imm","31":"46_bac","33":"48_pkit"}';
    @endphp
    <div class="container">
        <div class="row py-2">
            <div class="col-12 text-center">
                <div class="h3">API Simulate</div>
            </div>
        </div>

        <div class="row py-2">
            <div class="col-12 text-center">
                <form action="{{route("purchase.index")}}" method="post" id="purchase_source">
                    {{-- @csrf --}}
                    <div id="item-target">
                        <div class="row" id="">
                            <div class="col-6 font-weight-bold text-right">
                                Attribute
                            </div>
                            <div class="col-6 font-weight-bold text-left">
                                Value
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-6 text-right">
                                URN
                            </div>
                            <div class="col-6 text-left">
                                {{Request::getHost().'/purchase-index'}}
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-6 text-right">
                                Method
                            </div>
                            <div class="col-6 text-left">
                                POST
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-12">
                                <hr />
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-6 font-weight-bold text-right">
                                Parameter
                            </div>
                            <div class="col-6 font-weight-bold text-left">
                                Value
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-6 text-right">
                                email
                            </div>
                            <div class="col-6 text-left">
                                {{ $email }}
                                <input type="hidden" name="email" value="{{ $email }}" />
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-6 text-right">
                                first_name
                            </div>
                            <div class="col-6 text-left">
                                {{ $first_name }}
                                <input type="hidden" name="first_name" value="{{ $first_name }}" />
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-6 text-right">
                                last_name
                            </div>
                            <div class="col-6 text-left">
                                {{ $last_name }}
                                <input type="hidden" name="last_name" value="{{ $last_name }}" />
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-6 text-right">
                                address1
                            </div>
                            <div class="col-6 text-left">
                                {{ $address1 }}
                                <input type="hidden" name="address1" value="{{ $address1 }}" />
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-6 text-right">
                                suburb
                            </div>
                            <div class="col-6 text-left">
                                {{ $suburb }}
                                <input type="hidden" name="suburb" value="{{ $suburb }}" />
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-6 text-right">
                                state
                            </div>
                            <div class="col-6 text-left">
                                {{ $state }}
                                <input type="hidden" name="state" value="{{ $state }}" />
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-6 text-right">
                                postcode
                            </div>
                            <div class="col-6 text-left">
                                {{ $postcode }}
                                <input type="hidden" name="postcode" value="{{ $postcode }}" />
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-6 text-right">
                                country
                            </div>
                            <div class="col-6 text-left">
                                {{ $country }}
                                <input type="hidden" name="country" value="{{ $country }}" />
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-6 text-right">
                                tax_id
                            </div>
                            <div class="col-6 text-left">
                                {{ $tax_id }}
                                <input type="hidden" name="tax_id" value="{{ $tax_id }}" />
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-6 text-right">
                                member_id
                            </div>
                            <div class="col-6 text-left">
                                {{ $member_id }}
                                <input type="hidden" name="member_id" value="{{ $member_id }}" />
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-6 text-right">
                                parent_id
                            </div>
                            <div class="col-6 text-left">
                                {{ $parent_id }}
                                <input type="hidden" name="parent_id" value="{{ $parent_id }}" />
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-6 text-right">
                                url_id
                            </div>
                            <div class="col-6 text-left">
                                {{ $url_id }}
                                <input type="hidden" name="url_id" value="{{ $url_id }}" />
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-6 text-right">
                                allow_reports
                            </div>
                            <div class="col-6 text-left">
                                {{ $allow_reports }}
                                <input type="hidden" name="allow_reports" value="{{ $allow_reports }}" />
                            </div>
                        </div>
                        <div class="row" id="">
                            <div class="col-12">
                                <hr />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-light">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
@endsection
