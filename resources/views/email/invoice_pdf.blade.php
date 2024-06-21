<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Invoice | #{{str_pad($order->id, 5, '0', STR_PAD_LEFT)}}</title>
        <style type="text/css">
            * {
                font-family: Verdana, Arial, sans-serif;
            }
            table{
                font-size: x-small;
            }
            tfoot tr td{
                font-weight: bold;
                font-size: x-small;
            }
            th, td {
                padding: 2px;
            }
            .gray {
                background-color: lightgray
            }
        </style>
    </head>
    <body>

        <table style="width: 100%;" border="0" >
            <tr>
                <th align="left" style="font-size: 24px;">Invoice</th>
                <td align="right"><img src="img/cwb-logo-header.png" style="width: 100px;" /></td>
            </tr>
            <tr>
                <td align="left" colspan="2">
                    <table>
                        <tr>
                            <th align="left" style="width: 120px;">Invoice number</th>
                            <td align="left"># {{str_pad($order->id, 5, '0', STR_PAD_LEFT)}}</td>
                        </tr>
                        <tr>
                            <th align="left" style="width: 120px;">Reference number</th>
                            <td align="left">{{$order->ref_id}}</td>
                        </tr>
                        <tr>
                            <th align="left" style="width: 120px;">Date paid</th>
                            <td align="left">{{Carbon::parse($order->updated_at)->format('F d, Y')}}</td>
                        </tr>
                        <tr>
                            <th align="left" style="width: 120px;">Payment method</th>
                            <td align="left">Online Transfer / Credit Card</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="2">&nbsp;</td>
            </tr>
            <tr style="height: 82px;">
                <td align="left" valign="top">
                    <strong>Cell Wellbeing Dev</strong><br />
                    2624 N Main St<br />
                    Roswell, NY 88201<br />
                    United States<br />
                    +1 331-444-0123<br />
                    dev@cell-wellbeing.com<br />
                </td>
                <td align="left" valign="top">
                    <strong>Bill to</strong><br />
                    {{$order->customer->first_name}}&nbsp;{{$order->customer->last_name}}<br />
                    {{$order->customer->address1}}<br />
                    {{$order->customer->suburb}},&nbsp;{{$order->customer->state}}&nbsp;{{$order->customer->postcode}}<br />
                    {{$order->customer->country}}<br />
                    {{$order->customer->email}}<br />
                </td>
            </tr>
            <tr>
                <td align="left" colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <th align="left" colspan="2" style="font-size: 20px;">${{number_format($order->total_amount,2)}} paid on {{Carbon::parse($order->updated_at)->format('F d, Y')}}</th>
            </tr>
            <tr>
                <td align="left" colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td align="left" colspan="2">
                    <table style="width: 100%;">
                        <tr>
                            <th align="left" style="width: 50%;">Description</th>
                            <th align="center" style="width: 150px;">Qty</th>
                            <th align="left" style="width: 150px;">Unit Price</th>
                            <th align="right">Amount</th>
                        </tr>
                        <tr>
                            <td align="left" colspan="4"><hr /></td>
                        </tr>
                        {{-- Loop item here --}}
                        @php $xSum = 0; @endphp
                        @foreach ($order->orderDetails as $orderDetail)
                        <tr>
                            <td align="left" valign="top">{{$orderDetail->productDetail->desc}}</th>
                            <td align="center" valign="top">{{$qty = 1}}</th>
                            <td align="left" valign="top">${{number_format($orderDetail->price,2)}}</th>
                            <td align="right" valign="top">${{number_format($qty * $orderDetail->price,2)}}</th>
                        </tr>
                        @php $xSum += $qty * $orderDetail->price; @endphp
                        @endforeach
                        {{-- End of Loop item here --}}
                    </table>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td align="left">&nbsp;</td>
                <td align="right">
                    <table style="width: 100%;">
                        <tr>
                            <td align="left" colspan="2"><hr /></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top" style="width: 50%;">Sub Total</td>
                            <td align="right" valign="top">${{number_format($xSum,2)}}</td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2"><hr /></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top" style="width: 50%;">Total excluding tax</td>
                            <td align="right" valign="top">${{number_format($xSum,2)}}</td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2"><hr /></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top" style="width: 50%;">Sales Tax</td>
                            <td align="right" valign="top">${{number_format($order->tax_amount,2)}}</td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2"><hr /></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top" style="width: 50%;">Total</td>
                            <td align="right" valign="top">${{number_format($xSum + $order->tax_amount,2)}}</td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2"><hr /></td>
                        </tr>
                        <tr>
                            <th align="left" valign="top" style="width: 50%;">Amount paid</th>
                            <th align="right" valign="top">${{number_format($xSum + $order->tax_amount,2)}}</th>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="2" style="height: 50px;">&nbsp;</td>
            </tr>
            <tr>
                <th align="center" colspan="2">This is a computer generated invoice, no signature required.</th>
            </tr>
        </table>

    </body>
</html>
