<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static select()
 */
class Invoice extends Model
{
    use HasFactory;

    static public function search($query)
    {
        return Invoice::select()
            ->where('number', 'LIKE', '%' . $query . '%')
            ->when(preg_match('/^[\d:-]+$/', $query), function ($queryBuilder) use ($query) {
                return $queryBuilder->orWhere('date', 'LIKE', '%' . $query . '%');
            })
            ->orWhereIn('supplier_id', Supplier::select('id')
                ->where('name', 'LIKE', '%' . $query . '%'))
            ->orderBy('date', 'DESC');
    }

    static public function storeOrUpdate($request, $invoice = null)
    {
        if ($invoice === null) {
            $invoice = new Invoice;
        }
        $invoice->number = $request->number;
        $invoice->date = $request->date;

        $invoice->supplier_id = Supplier::where('name', $request->supplier)->first()->id;

        $invoice->save();

        $invoiceProduct = InvoiceProduct::changeInvoiceProducts($request, $invoice);

        if ($invoiceProduct) {
            if (InvoiceProduct::where('invoice_id', $invoice->id)->get()->isEmpty()) {
                $invoice->delete();
                return 'noProducts';
            }
        } else {
            return 'productsNoExists';
        }
        return $invoice;
    }

    static public function makeDefault()
    {
        $inv = new Invoice;
        $inv->number = 'A312412';
        $inv->supplier_id = 1;
        $inv->date = '2023-05-15 15:00';
        $inv->save();

        $inv = new Invoice;
        $inv->number = 'B421421';
        $inv->supplier_id = 2;
        $inv->date = '2023-05-02 17:30';
        $inv->save();

        $inv = new Invoice;
        $inv->number = 'C969512';
        $inv->supplier_id = 3;
        $inv->date = '2023-05-21 8:40';
        $inv->save();
    }
}
