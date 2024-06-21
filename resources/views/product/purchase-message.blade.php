@extends('layouts.user')

@section('custom-styles')
    <style>
        .plus-icon {
            width: 30px;
            height: 30px;
            border: 2px solid white;
            border-radius: 50%;
            position: relative;
            cursor: pointer;
        }

        .plus-icon:before,
        .plus-icon:after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 60%;
            height: 2px;
            background-color: white;
        }

        .plus-icon:before {
            transform: translate(-50%, -50%) rotate(90deg);
        }

        .plus-icon:after {
            transform: translate(-50%, -50%);
        }

        .custom-radius {
            border-radius: 30px;
        }
        .table-bordered > tr > * {
            border: 1px solid white;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        @if(Session::has('success') || Session::has('failed'))
        <div class="row py-3">
            <div class="col-12">
                <div class="row">
                    <div class="col-2"></div>
                    <div class="col-8">
                        @if(Session::has('success'))
                            <div class="alert alert-success text-center fs-3" role="alert">
                                {{Session::get('success')}}<br />
                                Order ID: <b>#{{str_pad(Session::get('order_id'), 5, '0', STR_PAD_LEFT)}}</b>
                            </div>
                        @endif
                        @if(Session::has('failed'))
                            <div class="alert alert-danger text-center fs-5" role="alert">
                                Failed status: "<b>{{Session::get('failed')}}</b>"
                            </div>
                        @endif
                    </div>
                    <div class="col-2"></div>
                </div>
            </div>
        </div>
        @endif

        <div class="row py-2">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 text-center">
                        @if(Session::has('resend_postal_data'))
                            <b>Redirecting in <span id="countdown">5</span></b>
                        @else
                            <a href="{{session('return_referer')}}" class="btn btn-light">Return To Homepage</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
@if(Session::has('resend_postal_data'))
<script>
    // Set the countdown time in seconds
    var countdownTime = 5;

    // Get the countdown element
    var countdownElement = document.getElementById("countdown");

    // Update the countdown every second
    var countdownInterval = setInterval(function() {
        // Decrement the countdown time
        countdownTime--;

        // Update the countdown element
        countdownElement.innerHTML = countdownTime;

        // If the countdown is over, redirect to the new page
        if (countdownTime == 0) {
            let url = "{{ session('return_referer') }}" + "postal/dealer-resend-accessories?status=OK&url_id=" + "{{ Session::get('url_id') }}" + "&postal_id=" + "{{ Session::get('resend_postal_data')->postal_id }}" + "&postal_code=" + "{{ Session::get('resend_postal_data')->postal_code }}";
            window.location.href = url;
        }
    }, 1000);
</script>
@endif
@endsection
