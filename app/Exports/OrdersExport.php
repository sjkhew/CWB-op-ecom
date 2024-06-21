<?php

namespace App\Exports;

use App\Order;
use App\OrderDetail;
use App\Customer;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Carbon;

class OrdersExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function query()
    {
        $specificYear = Carbon::now()->year;
        $specificMonth = Carbon::now()->month;
        $startDate = Carbon::create($specificYear, $specificMonth, 28)->subMonth()->format('Y-m-d');
        $endDate = Carbon::create($specificYear, $specificMonth, 27)->format('Y-m-d');

        // $startDate = '2023-09-28';
        // $endDate = '2023-12-28';

        $order = Order::with(['orderDetails', 'customer'])
        ->where('is_paid',1)
        ->whereBetween('created_at',[$startDate, $endDate])
        ->orderBy('created_at')
        ->select('orders.*');

        return $order;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Id',
            'First Name',
            'Last Name',
            'Email',
            'Postcode',
            'State',
            'Country',
            'Product SKU Id',
            'Product Id',
            'Product Name',
            'Credit Purchased',
        ];
    }

    public function map($order): array
    {
        $details = $order->orderDetails->map(function ($detail) {
            return [
                'Product SKU Id' => $detail->productSku->sku,
                'Product Id' => $detail->product_id,
                'Product Name' => $detail->product->name,
                'Credit Purchased' => $detail->qty,
            ];
        })->toArray();

        $rows = [];

        foreach ($details as $detail) {
            $row = [
                $order->created_at,
                $order->customer->member_id,
                $order->customer->first_name,
                $order->customer->last_name,
                $order->customer->email,
                $order->customer->postcode,
                $order->customer->state,
                $order->customer->country,
            ];

            $row = array_merge($row, $detail);

            $rows[] = $row;
        }

        return $rows;
    }
}
