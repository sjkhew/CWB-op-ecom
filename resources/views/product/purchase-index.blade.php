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
                    <div class="col-12">
                        <div class="h3 text-center">Order Page</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row py-2">
            <div class="col-xl-2 col-lg-3"></div>
            <div class="col-xl-8 col-lg-6">
                <form action="{{ route('purchase.payment') }}" method="post" id="purchase_payment">
                    @csrf
                    <div id="item-target">
                        <div class="row" id="item-1">
                            <div class="col-9 text-center">
                                <div class="form-group">
                                    <select name="products[]"
                                        class="form-select form-select-lg mb-3 custom-radius slt-product slt-product-1"
                                        product-attr="1" required>
                                        <option value="" selected disabled>Select Report</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" sku="{{ $product->productSku->sku }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <select name="product_details[]"
                                        class="form-select form-select-lg mb-3 custom-radius slt-qty slt-qty-1"
                                        qty-attr="1" required>
                                        <option value="" selected disabled>---</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row py-3">
                        <div class="col-12 text-left">
                            <a class="btn btn-primary" id="plus-icon"><i class="fas fa-plus-circle"></i> Add Report</a>
                        </div>
                    </div>

                    <div class="row py-3">
                        <div class="col-12">
                            <div id="summarise-table"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-center">
                            <input type="hidden" name="email" value="{{ $requestData['email'] }}" />
                            <input type="hidden" name="first_name" value="{{ $requestData['first_name'] }}" />
                            <input type="hidden" name="last_name" value="{{ $requestData['last_name'] }}" />
                            <input type="hidden" name="address1" value="{{ $requestData['address1'] }}" />
                            <input type="hidden" name="suburb" value="{{ $requestData['suburb'] }}" />
                            <input type="hidden" name="state" value="{{ $requestData['state'] }}" />
                            <input type="hidden" name="postcode" value="{{ $requestData['postcode'] }}" />
                            <input type="hidden" name="country" value="{{ $requestData['country'] }}" />
                            <input type="hidden" name="tax_id" value="{{ $requestData['tax_id'] }}" />
                            <input type="hidden" name="member_id" value="{{ $requestData['member_id'] }}" />
                            <input type="hidden" name="parent_id" value="{{ $requestData['parent_id'] }}" />
                            <input type="hidden" name="url_id" value="{{ $requestData['url_id'] }}" />
                            <input type="hidden" name="referer" value="{{ $data['referer'] }}" />
                            <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xl-2 col-lg-3"></div>
        </div>
    </div>
@endsection

@section('custom-scripts')
    <script>
        $(document).ready(function() {
            // Function to update IDs and select tag classes
            function updateIdsAndClasses(item) {
                var oldItemCount = $('#item-target').children().length;
                var newItemCount = $('#item-target').children().length + 1;
                var itemId = "item-" + newItemCount;
                var sltProduct = "slt-product-" + newItemCount;
                var sltQty = "slt-qty-" + newItemCount;
                item.attr("id", itemId);
                item.find("select.slt-product-" + oldItemCount).removeClass("slt-product-" + oldItemCount).addClass(sltProduct);
                item.find("select.slt-qty-" + oldItemCount).removeClass("slt-qty-" + oldItemCount).addClass(sltQty);
                item.find("select.slt-product-" + newItemCount).attr("product-attr", newItemCount);
                item.find("select.slt-qty-" + newItemCount).attr("qty-attr", newItemCount);
            }

            // Clone button click event handler
            $("#plus-icon").click(function() {
                var lastChildId = $('#item-target').children().last().attr('id');
                var clonedItem = $("#" + lastChildId).clone();
                updateIdsAndClasses(clonedItem);
                clonedItem.appendTo("#item-target");

                // Remove option after cloned
                var itemCount = $('#item-target').children().length;
                $('select.slt-qty-' + itemCount).find('option:not(:eq(0))').remove();
            });
        });

        // Re-initialise event listener dramatically after added new element
        $(document).on('change', '.slt-product', function() {
            var currentProductAttr = $(this).attr('product-attr');
            var selectElement = $('.slt-qty-' + currentProductAttr);
            var itemCount = selectElement.find('option').length;

            var productId = $('.slt-product-' + currentProductAttr).val();

            var selectedProductNo = 'select.slt-product-' + currentProductAttr;
            var selectedProductVal = $(selectedProductNo).val();
            var selectedSku = $(selectedProductNo + ' option[value="' + selectedProductVal + '"]').attr('sku');

            $.when(
                $.ajax({
                    url: '{{env("BUSINESS_PORTAL_DEALER_URL")}}',
                    method: 'POST',
                    data: {
                        action: 'get-stock-balance',
                        time: "{{ $data['time'] }}",
                        signature: "{{ $data['signature'] }}",
                        member_id: "{{ $data['member_id'] }}",
                        parent_id: "{{ $data['parent_id'] }}",
                        url_id: "{{ $data['url_id'] }}",
                        sku: selectedSku,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {
                        if(result['err']){
                            // console.log(result['err']);
                        }else{
                            // console.log(result['sku']);
                        }
                        window['bal' + currentProductAttr] = result['bal'];
                        console.log('1.' + window['bal' + currentProductAttr]);
                    },
                    error: function(xhr, status, error) {
                        console.log('Error 2:', error);
                    },
                    dataType: 'json'
                })
            ).done(function(){
                $.ajax({
                    url: '{{ route('query.product.details') }}',
                    method: 'POST',
                    data: {
                        id: productId,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {
                        console.log('2.' + window['bal' + currentProductAttr]);
                        if (typeof window['bal' + currentProductAttr] === 'undefined'){
                            location.reload(true);
                        }else if(window['bal' + currentProductAttr] > 0){
                            // Empty the current option element
                            selectElement.empty();
                            var newOption = $('<option>', {
                                value: '',
                                text: '---',
                                disabled: true,
                                selected: true,
                            });
                            selectElement.append(newOption);

                            // Add the item available options
                            $.each(result, function(key, value) {
                                // Create a new option element
                                newOption = $('<option>', {
                                    value: value['id'],
                                    text: value['qty'],
                                    'price-attr': value['price'].toFixed(2),
                                    'desc-attr': value['desc'],
                                    'qty-attr': value['qty'],
                                });
                                // Append the new option to the select element
                                if(window['bal' + currentProductAttr] >= value['qty']){
                                    selectElement.append(newOption);
                                }
                            });
                        }else{
                            $('.slt-product-' + currentProductAttr + ' option[value="' + productId + '"]').prop('disabled', true);
                            $('.slt-product-' + currentProductAttr).prev('option:selected');
                            alert("Insufficient Stock Balance.");

                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    },
                    dataType: 'json'
                });
            });
        });

        $(document).on('change', '.slt-qty', function() {

            // Count the total selected data
            var count = $('.slt-qty').filter(':visible').length;

            // Empty the table
            $('#summarise-table').empty();

            // Initialise Summarise Table
            var summariseTable = $('<table>', {
                'class': 'table table-bordered text-light'
            });

            // Prepare the table header
            var headerRow = $('<tr>');
            var headerCell1 = $('<th>', {
                text: 'Report'
            });
            var headerCell2 = $('<th>', {
                class: 'text-right',
                text: 'Quantity'
            });
            var headerCell3 = $('<th>', {
                class: 'text-right',
                text: 'Price (USD)'
            });

            // Append cell header to row
            headerRow.append(headerCell1);
            // headerRow.append(headerCell2);
            headerRow.append(headerCell3);

            // Append row header to table
            summariseTable.append(headerRow);

            // Append table into div
            $('#summarise-table').append(summariseTable);

            var sumTotal = 0;

            for (var i = 1; i <= count; i++) {

                var selectedOption = $('.slt-qty-' + i).find('option:selected');
                var selectQtyVal = selectedOption.attr('qty-attr');
                var selectPriceVal = selectedOption.attr('price-attr');
                var selectDescVal = selectedOption.attr('desc-attr');

                var current_row = $('<tr>');

                // Prepare the column data
                var cell1 = $('<td>', {
                    text: selectDescVal
                });
                var cell2 = $('<td>', {
                    class: 'text-right',
                    text: selectQtyVal
                });
                var cell3 = $('<td>', {
                    class: 'text-right',
                    text: selectPriceVal
                });

                current_row.append(cell1);
                // current_row.append(cell2);
                current_row.append(cell3);

                summariseTable.append(current_row);

                sumTotal += parseFloat(selectPriceVal);
            }

            var sum_row = $('<tr>');

            // Prepare the column data
            var cell1 = $('<th>', {
                class: 'text-right',
                colspan: '1',
                text: 'Sum Total (USD)'
            });
            var cell2 = $('<th>', {
                class: 'text-right',
                text: sumTotal.toFixed(2)
            });

            sum_row.append(cell1);
            sum_row.append(cell2);

            summariseTable.append(sum_row);
        });
    </script>
@endsection
