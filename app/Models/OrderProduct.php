<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    static public function changeInvoiceProducts($request, $order)
    {
        $requestData = $request->all();

        $productNames = preg_grep('/^product_\d+$/', array_keys($requestData));
        $productAmounts = preg_grep('/^product_\d+_amount$/', array_keys($requestData));

        $filteredProductNames = array_filter(array_map(function ($key) use ($request) {
            return $request->get($key);
        }, $productNames));

        $filteredProductAmounts = array_filter(array_map(function ($key) use ($request) {
            return $request->get($key);
        }, $productAmounts));

//        return $order;
//        $quantities = OrderProduct::select('product_id', 'quantity')->where('order_id', $order->id)->get();
        OrderProduct::where('order_id', $order->id)->delete();

        $result = 'ok';

        foreach ($filteredProductNames as $key => $productName) {
            $product = Product::where('name', $productName)->first();
            if (!$product) {
                $result = 'productsNoExist';
                break;
            } else {
                $orderProduct = new OrderProduct;
                $orderProduct->product_id = $product->id;
                $orderProduct->order_id = $order->id;
                if (isset($filteredProductAmounts[$key + 1]) && $filteredProductAmounts[$key + 1] != 0) {
                    if ($filteredProductAmounts[$key + 1] <= $product->quantity) {
                        $orderProduct->count = $filteredProductAmounts[$key + 1];
                        $orderProduct->selling_price = $product->selling_price;
                        $product->quantity -= $filteredProductAmounts[$key + 1];
                    } else {
                        $result = 'noQuantity';
                        break;
                    }
                    $orderProduct->save();
                    $product->save();
                }
            }
        }
        return $result;
    }

    static public function makeDefault()
    {
        $op = new OrderProduct;
        $op->product_id = 1;
        $op->order_id = 1;
        $op->count = 1;
        $op->selling_price = 15499.49;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 1;
        $op->order_id = 2;
        $op->count = 2;
        $op->selling_price = 15499.49;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 2;
        $op->order_id = 2;
        $op->count = 4;
        $op->selling_price = 42000.00;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 3;
        $op->order_id = 2;
        $op->count = 4;
        $op->selling_price = 58000.00;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 4;
        $op->order_id = 3;
        $op->count = 1;
        $op->selling_price = 39000.00;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 5;
        $op->order_id = 3;
        $op->count = 1;
        $op->selling_price = 62000.00;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 6;
        $op->order_id = 4;
        $op->count = 1;
        $op->selling_price = 33000.00;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 7;
        $op->order_id = 5;
        $op->count = 2;
        $op->selling_price = 59000.00;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 8;
        $op->order_id = 5;
        $op->count = 1;
        $op->selling_price = 50000.00;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 9;
        $op->order_id = 6;
        $op->count = 3;
        $op->selling_price = 24999.99;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 10;
        $op->order_id = 7;
        $op->count = 1;
        $op->selling_price = 599.99;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 11;
        $op->order_id = 7;
        $op->count = 1;
        $op->selling_price = 1099.99;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 12;
        $op->order_id = 8;
        $op->count = 1;
        $op->selling_price = 2499.99;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 13;
        $op->order_id = 8;
        $op->count = 2;
        $op->selling_price = 10999.99;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 14;
        $op->order_id = 9;
        $op->count = 2;
        $op->selling_price = 29999.99;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 15;
        $op->order_id = 9;
        $op->count = 4;
        $op->selling_price = 3999.99;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 16;
        $op->order_id = 9;
        $op->count = 1;
        $op->selling_price = 19999.99;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 18;
        $op->order_id = 9;
        $op->count = 1;
        $op->selling_price = 59999.99;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 22;
        $op->order_id = 10;
        $op->count = 4;
        $op->selling_price = 8499.99;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 23;
        $op->order_id = 10;
        $op->count = 1;
        $op->selling_price = 5999.99;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 28;
        $op->order_id = 11;
        $op->count = 1;
        $op->selling_price = 37999.99;
        $op->save();

        $op = new OrderProduct;
        $op->product_id = 14;
        $op->order_id = 11;
        $op->count = 1;
        $op->selling_price = 29999.99;
        $op->save();
    }
}
