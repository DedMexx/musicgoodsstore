<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpecificationRequest;
use App\Models\Specification;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SpecificationController extends MainController
{
    protected string $tableName = 'specification';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $table = Specification::search($request->input('search'))
                ->paginate(self::$perPage);
        } else {
            $table = Specification::orderBy('name', 'ASC')
                ->paginate(self::$perPage);
        }
        if ($request->has('page')) {
            $page = intval($request->query('page'));
            if ($page < 1 || $page > $table->lastPage()) {
                abort(404);
            }
        }
        return view('specification.index', compact('table'))
            ->with('title', 'Характеристики')
            ->with('query', $request->input('search') ?? '')
            ->with('tableName', $this->tableName);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('specification.create')
            ->with('title', 'Добавить характеристику')
            ->with('tableName', $this->tableName);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpecificationRequest $request)
    {
        try {
            Specification::storeOrUpdate($request);
            return redirect()->route('specification.index');
        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1062) {
                return back()
                    ->withInput()
                    ->withErrors(['name' => 'Данная характеристика уже существует']);
            }
        }
        return back()
            ->withInput()
            ->withErrors(['error' => 'Произошла ошибка сохранения характеристики']);
    }

    public function show() {
        return view('errors.404');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specification $specification)
    {
        return view('specification.edit', compact('specification'))
            ->with('title', 'Изменить характеристику')
            ->with('tableName', $this->tableName);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SpecificationRequest $request, Specification $specification)
    {
        try {
            Specification::storeOrUpdate($request, $specification);
            return redirect()->route('specification.index');
        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1062) {
                return back()
                    ->withInput()
                    ->withErrors(['name' => 'Данная характеристика уже существует']);
            }
        }
        return back()
            ->withInput()
            ->withErrors(['error' => 'Произошла ошибка сохранения характеристики']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specification $specification)
    {
        try {
            $specification->delete();
            return redirect()->back();
        }
        catch (QueryException) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Произошла ошибка удаления характеристики']);
        }
    }
}
