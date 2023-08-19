<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CategoryController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    protected string $tableName = 'category';

    public function index(Request $request)
    {
        if ($request->has('search')) {
            $table = Category::search($request->input('search'))->paginate(self::$perPage);
        } else {
            $table = Category::orderBy('name', 'ASC')->paginate(self::$perPage);
        }
        if ($request->has('page')) {
            $page = intval($request->query('page'));
            if ($page < 1 || $page > $table->lastPage()) {
                abort(404);
            }
        }
        return view('category.index', compact('table'))
            ->with('title', 'Категории')
            ->with('query', $request->input('search') ?? '')
            ->with('tableName', $this->tableName);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create')
            ->with('title', 'Добавить категорию')
            ->with('tableName', $this->tableName);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try {
            Category::storeOrUpdate($request);
            return redirect()->route('category.index');
        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1062) {
                return back()->withInput()->withErrors(['name' => 'Данная категория уже существует']);
            }
        }
        return back()
            ->withInput()
            ->withErrors(['error' => 'Произошла ошибка сохранения категории']);
    }

    public function show()
    {
        return view('errors.404');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'))
            ->with('title', 'Изменить категорию')
            ->with('tableName', $this->tableName);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            Category::storeOrUpdate($request, $category);
            return redirect()->route('category.index');
        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1062) {
                return back()
                    ->withInput()
                    ->withErrors(['name' => 'Данная категория уже существует']);
            }
        }
        return back()
            ->withInput()
            ->withErrors(['error' => 'Произошла ошибка сохранения категории']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return redirect()->back();
        } catch (QueryException) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Произошла ошибка удаления категории']);
        }
    }
}
