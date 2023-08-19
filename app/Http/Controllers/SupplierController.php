<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SupplierController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    protected string $tableName = 'supplier';

    public function index(Request $request)
    {
        if ($request->has('search')) {
            $query = $request->input('search');
            $table = Supplier::search($query)
                ->paginate(self::$perPage);
        } else {
            $table = Supplier::orderBy('name', 'ASC')
                ->paginate(self::$perPage);
        }
        if ($request->has('page')) {
            $page = intval($request->query('page'));
            if ($page < 1 || $page > $table->lastPage()) {
                abort(404);
            }
        }
        return view('supplier.index', compact('table'))
            ->with('title', 'Поставщики')
            ->with('query', $query ?? '')
            ->with('tableName', $this->tableName);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.create')
            ->with('title', 'Добавить поставщика')
            ->with('tableName', $this->tableName);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        try {
            $supplier = Supplier::storeOrUpdate($request);
            return redirect()->route('supplier.show', ['supplier' => $supplier]);
        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1062) {
                if (str_contains($ex->getMessage(), 'suppliers_email_unique')) {
                    return back()
                        ->withInput()
                        ->withErrors(['email' => 'Поставщик с таким e-mail уже существует']);
                } elseif (str_contains($ex->getMessage(), 'suppliers_phone_unique')) {
                    return back()
                        ->withInput()
                        ->withErrors(['phone' => 'Поставщик с таким номером телефона уже существует']);
                } else {
                    return back()
                        ->withInput()
                        ->withErrors(['name' => 'Поставщик с таким именем уже существует']);
                }
            }
        }
        return back()
            ->withInput()
            ->withErrors(['error' => 'Произошла ошибка сохранения поставщика']);
    }


    public function show(Supplier $supplier)
    {
        return view('supplier.show', compact('supplier'))
            ->with('title', 'Поставщик «' . $supplier->name . '»')
            ->with('tableName', $this->tableName);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'))
            ->with('title', 'Изменить поставщика')
            ->with('tableName', $this->tableName);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        try {
            Supplier::storeOrUpdate($request, $supplier);
            return redirect()->route('supplier.show', ['supplier' => $supplier]);
        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1062) {
                if (str_contains($ex->getMessage(), 'suppliers_email_unique')) {
                    return back()
                        ->withInput()
                        ->withErrors(['email' => 'Поставщик с таким e-mail уже существует']);
                } elseif (str_contains($ex->getMessage(), 'suppliers_phone_unique')) {
                    return back()
                        ->withInput()
                        ->withErrors(['phone' => 'Поставщик с таким номером телефона уже существует']);
                } else {
                    return back()
                        ->withInput()
                        ->withErrors(['name' => 'Поставщик с таким именем уже существует']);
                }
            }
        }
        return back()
            ->withInput()
            ->withErrors(['error' => 'Произошла ошибка сохранения поставщика']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
            return redirect()->route('supplier.index');
        }
        catch (QueryException) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Произошла ошибка удаления поставщика']);
        }
    }
}
