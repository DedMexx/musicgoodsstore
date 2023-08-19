<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManufacturerRequest;
use App\Models\Manufacturer;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ManufacturerController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    protected string $tableName = 'manufacturer';

    public function index(Request $request)
    {
        if ($request->has('search')) {
            $query = $request->input('search');
            $table = Manufacturer::search($query)
                ->paginate(self::$perPage);
        } else {
            $table = Manufacturer::orderBy('name', 'ASC')
                ->paginate(self::$perPage);
        }
        if ($request->has('page')) {
            $page = intval($request->query('page'));
            if ($page < 1 || $page > $table->lastPage()) {
                abort(404);
            }
        }
        return view('manufacturer.index', compact('table'))
            ->with('title', 'Производители')
            ->with('query', $query ?? '')
            ->with('tableName', $this->tableName);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('manufacturer.create')
            ->with('title', 'Добавить поизводителя')
            ->with('tableName', $this->tableName);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ManufacturerRequest $request)
    {
        try {
            Manufacturer::storeOrUpdate($request);
            return redirect()->route('manufacturer.index');
        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1062) {
                return back()
                    ->withInput()
                    ->withErrors(['name' => 'Данный производитель уже существует']);
            }
        }
    }

    public function show()
    {
        return view('errors.404');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manufacturer $manufacturer)
    {
        return view('manufacturer.edit', compact('manufacturer'))
            ->with('title', 'Изменить производителя')
            ->with('tableName', $this->tableName);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ManufacturerRequest $request, Manufacturer $manufacturer)
    {
        try {
            Manufacturer::storeOrUpdate($request, $manufacturer);
            return redirect()->route('manufacturer.index');
        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1062) {
                return back()->withInput()->withErrors(['name' => 'Данный производитель уже существует']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturer->delete();
        return redirect()->back();
    }
}
