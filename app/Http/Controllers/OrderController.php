<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_orders|edit_orders'])->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::query()->with('orderItems')->paginate(5);
        return response()->success(OrderResource::collection($orders)->response()->getData());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $orderItems = $order->orderItems()->paginate(20);
        return response()->success(OrderItemResource::collection($orderItems)->response()->getData());
    }

    public function exportToCSV()
    {
        $fileName = 'orders.csv';
        $orders = Order::all();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('ID', 'Name', 'Email', 'Product title', 'Price', 'Quantity', 'Total');

        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                $row['ID']  = $order->id;
                $row['Name']    = $order->name;
                $row['Email']    = $order->email;
                $row['Product title']  ='';
                $row['Price']  = '';
                $row['Quantity']  = '';
                $row['Total']  = $order->total;

                fputcsv($file, $row);

                foreach ($order->orderItems as $orderItem) {
                    fputcsv($file, ['', '', '', $orderItem->product_title, (float)$orderItem->price, $orderItem->quantity, '']);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
