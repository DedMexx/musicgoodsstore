<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InvoiceProduct extends Model
{
    use HasFactory;

    public static function getCostsByDate($request)
    {
        return InvoiceProduct::select('invoices.date', DB::raw('SUM(purchase_price*invoice_products.quantity) AS cost_per_day'))
            ->join('invoices', 'invoice_id', 'invoices.id')
            ->join('products', 'invoice_products.product_id', 'products.id')
            ->when($request->input('startDate'), function ($query, $startDate) {
                return $query->where('date', '>=', $startDate);
            })
            ->when($request->input('endDate'), function ($query, $endDate) {
                return $query->where('date', '<=', $endDate);
            })
            ->groupBy('invoices.date')
            ->get();
    }

    static public function changeInvoiceProducts($request, $invoice)
    {
        $requestData = $request->all();

        $filteredProductLabelsNames = preg_grep('/^product_\d+_label$/', array_keys($requestData));
        $filteredProductValuesNames = preg_grep('/^product_\d+$/', array_keys($requestData));

        $productLabelsValues = array_filter(array_map(function ($key) use ($request) {
            return $request->get($key);
        }, $filteredProductLabelsNames));

        $productValues = array_filter(array_map(function ($key) use ($request) {
            return $request->get($key);
        }, $filteredProductValuesNames));

        $quantities = InvoiceProduct::select('product_id', 'quantity')->where('invoice_id', $invoice->id)->get();
        InvoiceProduct::where('invoice_id', $invoice->id)->delete();

        $result = true;

        foreach ($productLabelsValues as $key => $productName) {
            $product = Product::where('name', $productName)->first();
            if (!$product) {
                $result = false;
                break;
            } else {
                $invoiceProduct = new InvoiceProduct;
                $invoiceProduct->product_id = $product->id;
                $invoiceProduct->invoice_id = $invoice->id;
                if (isset($productValues[$key + 1]) && $productValues[$key + 1] != 0) {
                    $invoiceProduct->quantity = $productValues[$key + 1];
                    $product->quantity += $productValues[$key + 1];

                    $invoiceProduct->save();
                    foreach ($quantities as $quantity) {
                        if ($product->id === $quantity->product_id) {
                            $product->quantity -= $quantity->quantity;
                        }
                    }
                    $product->save();
                }
            }
        }
        return $result;
    }

    static public function makeDefault()
    {
        $ip = new InvoiceProduct;
        $ip->invoice_id = 1;
        $ip->product_id = 1;
        $ip->quantity = 10;
        $ip->save();

        $ip = new InvoiceProduct;
        $ip->invoice_id = 1;
        $ip->product_id = 4;
        $ip->quantity = 11;
        $ip->save();

        $ip = new InvoiceProduct;
        $ip->invoice_id = 1;
        $ip->product_id = 5;
        $ip->quantity = 5;
        $ip->save();

        $ip = new InvoiceProduct;
        $ip->invoice_id = 2;
        $ip->product_id = 2;
        $ip->quantity = 15;
        $ip->save();

        $ip = new InvoiceProduct;
        $ip->invoice_id = 2;
        $ip->product_id = 6;
        $ip->quantity = 22;
        $ip->save();

        $ip = new InvoiceProduct;
        $ip->invoice_id = 3;
        $ip->product_id = 3;
        $ip->quantity = 22;
        $ip->save();
    }
}
