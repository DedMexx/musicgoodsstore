<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Client;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PaymentController extends MainController
{
    protected string $tableName = 'payment';

    public function index(Request $request)
    {
        if ($request->has('search')) {
            $query = $request->input('search');
            $table = Payment::search($query)
                ->paginate(self::$perPage);

        } else {
            $table = Payment::orderBy('date', 'DESC')
                ->paginate(self::$perPage);
        }
        if ($request->has('page')) {
            $page = intval($request->query('page'));
            if ($page < 1 || $page > $table->lastPage()) {
                abort(404);
            }
        }
        return view('payment.index', compact('table'))
            ->with('title', 'Платежи')
            ->with('query', $query ?? '')
            ->with('tableName', $this->tableName);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('payment.create')
            ->with('order', $request->input('order'))
            ->with('title', 'Добавить платеж')
            ->with('tableName', $this->tableName);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentRequest $request)
    {
        if ($request->has('order')) {
            $payment = Payment::storeOrUpdate($request);
            return redirect()->route('order.show', ['order' => $request->input('order')]);
        }
        return back()->withInput()->withErrors(['error' => 'Произошла ошибка сохранения платежа']);
    }


    public function show(Payment $payment)
    {
        return abort(404);
//        return view('payment.show', compact('payment'))
//            ->with('title', '«' . $payment->name . '»')
//            ->with('tableName', $this->tableName);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        return view('payment.edit', compact('payment'))
            ->with('title', 'Изменить платеж')
            ->with('tableName', $this->tableName);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentRequest $request, Payment $payment)
    {
        try {
            $payment = Payment::storeOrUpdate($request, $payment);
            return redirect()->route('order.show', ['order' => $payment->order_id]);
        }
        catch (QueryException $exception) {
            return back()->withInput()->withErrors(['error' => 'Произошла ошибка сохранения товара']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payment.index');
    }
}
