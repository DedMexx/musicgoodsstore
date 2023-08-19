<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    static public function search($request = null)
    {
        $search = $request->input('search');

        $subquery = Payment::select('order_id', DB::raw('SUM(amount) AS paid'))
            ->groupBy('order_id');

        return Order::select('orders.id', 'orders.date', DB::raw('SUM(order_products.selling_price*order_products.count) AS cost'), 'client_id',
            'last_name', 'first_name', 'third_name', 'email', 'phone', 'paid', DB::raw('SUM(order_products.count) AS count'))
            ->join('order_products', 'order_products.order_id', 'orders.id')
            ->join('clients', 'client_id', 'clients.id')
            ->leftJoinSub($subquery, 'payments', function ($join) {
                $join->on('orders.id', '=', 'payments.order_id');
            })
            ->when($request->input('startDate'), function ($query, $startDate) {
                return $query->where('orders.date', '>=', $startDate);
            })
            ->when($request->input('endDate'), function ($query, $endDate) {
                return $query->where('orders.date', '<=', $endDate);
            })
            ->when(preg_match('/^[0-9:-]+$/', $search), function ($queryBuilder) use ($search) {
                return $queryBuilder->where('date', 'LIKE', '%' . $search . '%');
            })
            ->when($search, function ($query, $search) {
                return $query
                    ->whereRaw("CONCAT(last_name, ' ', first_name, ' ', third_name) LIKE '%" . $search . "%'")
                    ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE '%" . $search . "%'")
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%');
            })
            ->groupBy('orders.id', 'orders.date', 'client_id', 'last_name', 'first_name', 'third_name', 'email', 'phone', 'paid');
    }

    static public function storeOrUpdate($request, $order = null)
    {
        if ($order === null) {
            $order = new Order();
        }
        $order->client_id = Client::where('email', $request->email)->first()->id;
        $order->date = $request->date;

        $order->save();

        $orderProduct = OrderProduct::changeInvoiceProducts($request, $order);

        if ($orderProduct === 'ok') {
            if (OrderProduct::where('order_id', $order->id)->get()->isEmpty()) {
                $order->delete();
                return 'noProducts';
            }
        } else {
            return $orderProduct;
        }
        return $order;
    }

    static public function makeDefault()
    {
        $order = new Order;
        $order->date = '2023-05-22 15:35';
//        $order->total_cost = 10000.00;
        $order->client_id = 1;
        $order->save();

        $order = new Order;
        $order->date = '2023-05-11 12:15';
//        $order->total_cost = 120000.00;
        $order->client_id = 2;
        $order->save();

        $order = new Order;
        $order->date = '2023-05-22 8:51';
//        $order->total_cost = 31575.50;
        $order->client_id = 3;
        $order->save();

        $order = new Order;
        $order->date = '2023-05-23 9:51';
//        $order->total_cost = 31575.50;
        $order->client_id = 4;
        $order->save();

        $order = new Order;
        $order->date = '2023-05-30 11:51';
//        $order->total_cost = 31575.50;
        $order->client_id = 5;
        $order->save();

        $order = new Order;
        $order->date = '2023-06-01 8:22';
//        $order->total_cost = 31575.50;
        $order->client_id = 6;
        $order->save();

        $order = new Order;
        $order->date = '2023-05-28 11:53';
//        $order->total_cost = 31575.50;
        $order->client_id = 7;
        $order->save();

        $order = new Order;
        $order->date = '2023-05-29 16:31';
//        $order->total_cost = 31575.50;
        $order->client_id = 8;
        $order->save();

        $order = new Order;
        $order->date = '2023-05-22 12:32';
//        $order->total_cost = 31575.50;
        $order->client_id = 9;
        $order->save();

        $order = new Order;
        $order->date = '2023-05-27 13:44';
//        $order->total_cost = 31575.50;
        $order->client_id = 10;
        $order->save();

        $order = new Order;
        $order->date = '2023-05-30 18:51';
//        $order->total_cost = 31575.50;
        $order->client_id = 11;
        $order->save();
    }
}
