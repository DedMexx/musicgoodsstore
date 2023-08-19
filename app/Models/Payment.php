<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use HasFactory;

    static public function search($query)
    {
        return Payment::select()
            ->whereIn('order_id', Order::select('id')
                ->whereIn('client_id', Client::select('id')
                    ->whereRaw("CONCAT(last_name, ' ', first_name, ' ', third_name) LIKE '%" . $query . "%'")
                    ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE '%" . $query . "%'")
                    ->orWhere('email', 'LIKE', '%' . $query . '%')
                    ->orWhere('phone', 'LIKE', '%' . $query . '%')
                ))
            ->when(preg_match('/^[0-9:-]+$/', $query), function ($queryBuilder) use ($query) {
                return $queryBuilder->orWhere('date', 'LIKE', '%' . $query . '%');
            })
            ->orderBy('date', 'DESC');
    }

    static public function getPaymentsByDate($request)
    {
        return Payment::select('payments.date', DB::raw('SUM(payments.amount) AS income_per_day'))
            ->when($request->input('startDate'), function ($query, $startDate) {
                return $query->where('date', '>=', $startDate);
            })
            ->when($request->input('endDate'), function ($query, $endDate) {
                return $query->where('date', '<=', $endDate);
            })
            ->groupBy('payments.date')
            ->get();
    }

    static public function storeOrUpdate($request, $payment = null)
    {
        if (is_null($payment)) {
            $payment = new Payment;
        }
        $payment->date = $request->date;
        $payment->amount = $request->amount;
        if ($request->has('order')) {
            $payment->order_id = $request->input('order');
        }
        $payment->save();
        return $payment;
    }

    static public function makeDefault()
    {
        $p = new Payment;
        $p->order_id = 1;
        $p->amount = 10000.00;
        $p->date = '2023-05-23 15:34';
        $p->save();

        $p = new Payment;
        $p->order_id = 2;
        $p->amount = 50000.00;
        $p->date = '2023-05-23 14:43';
        $p->save();

        $p = new Payment;
        $p->order_id = 2;
        $p->amount = 60000.00;
        $p->date = '2023-05-24 11:55';
        $p->save();

        $p = new Payment;
        $p->order_id = 2;
        $p->amount = 10000.00;
        $p->date = '2023-05-26 18:45';
        $p->save();

        $p = new Payment;
        $p->order_id = 3;
        $p->amount = 15000.00;
        $p->date = '2023-05-23 15:34';
        $p->save();

        $p = new Payment;
        $p->order_id = 3;
        $p->amount = 16575.00;
        $p->date = '2023-05-25 11:34';
        $p->save();
    }
}
