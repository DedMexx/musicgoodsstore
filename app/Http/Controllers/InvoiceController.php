<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class InvoiceController extends MainController
{
    protected string $tableName = 'invoice';

    public function index(Request $request)
    {
        if ($request->has('search')) {
            $query = $request->input('search');
            $table = Invoice::search($query)
                ->paginate(self::$perPage);
        } else {
            $table = Invoice::orderBy('date', 'DESC')
                ->paginate(self::$perPage);
        }
        if ($request->has('page')) {
            $page = intval($request->query('page'));
            if ($page < 1 || $page > $table->lastPage()) {
                abort(404);
            }
        }
        return view('invoice.index', compact('table'))
            ->with('title', 'Накладные')
            ->with('query', $query ?? '')
            ->with('tableName', $this->tableName);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('invoice.create')
            ->with('title', 'Добавить накладную')
            ->with('tableName', $this->tableName);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceRequest $request)
    {
        try {
            $invoice = Invoice::storeOrUpdate($request);
            if ($invoice === 'noProducts') {
                return back()
                    ->withInput()
                    ->withErrors(['category' => 'Необходимо указать хотя бы один товар в накладной']);
            }
            if ($invoice === 'productsNoExists') {
                return back()
                    ->withInput()
                    ->withErrors(['specification' => 'Указанные товары не существуют']);
            }
            return redirect()->route('invoice.index');

        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1062) {
                return back()
                    ->withInput()
                    ->withErrors(['name' => 'Накладная с таким номером уже существует']);
            }
//            else {
//                return back()
//                    ->withInput()
//                    ->withErrors(['error' => $ex->getMessage()]);
//            }
        }
        return back()
            ->withInput()
            ->withErrors(['error' => 'Произошла ошибка сохранения накладной']);
    }


    public function show(Invoice $invoice)
    {
        return view('invoice.show', compact('invoice'))
            ->with('title', '«' . $invoice->name . '»')
            ->with('tableName', $this->tableName);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        return view('invoice.edit', compact('invoice'))
            ->with('title', 'Изменить накладную ' . $invoice->number)
            ->with('tableName', $this->tableName);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        try {
            $invoice = Invoice::storeOrUpdate($request, $invoice);
            if ($invoice === 'noProducts') {
                return back()
                    ->withInput()
                    ->withErrors(['category' => 'Необходимо указать хотя бы один товар в накладной']);
            }
            if ($invoice === 'productsNoExists') {
                return back()
                    ->withInput()
                    ->withErrors(['specification' => 'Указанные товары не существуют']);
            }
            return redirect()->route('invoice.index');

        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1062) {
                return back()
                    ->withInput()
                    ->withErrors(['name' => 'Накладная с таким номером уже существует']);
            }
//            else {
//                return back()
//                    ->withInput()
//                    ->withErrors(['error' => $ex->getMessage()]);
//            }
        }
        return back()
            ->withInput()
            ->withErrors(['error' => 'Произошла ошибка сохранения накладной']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        try {
            $invoice->delete();
            return redirect()->route('invoice.index');
        }
        catch (QueryException) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Произошла ошибка удаления накладной']);
        }
    }
}
