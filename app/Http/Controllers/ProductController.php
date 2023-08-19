<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Specification;
use App\Models\SpecificationProduct;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductController extends MainController
{
    protected string $tableName = 'product';

    public function autocomplete(Request $request)
    {
        $query = $request->get('query');
        $result = Manufacturer::select('name')
            ->where('name', 'LIKE', '%' . $query . '%')
            ->distinct()
            ->limit(5)
            ->get();
//        if (count($result)<1) {
//
//        }
        return response()->json($result);
    }

    public function index(Request $request)
    {
        if ($request->has('search')) {
            $query = $request->input('search');
            $table = Product::search($query)
                ->paginate(self::$perPage);
//            return $table
        } else {
            $table = Product::orderBy('name', 'ASC')
                ->paginate(self::$perPage);
        }
        if ($request->has('page')) {
            $page = intval($request->query('page'));
            if ($page < 1 || $page > $table->lastPage()) {
                abort(404);
            }
        }
        return view('product.index', compact('table'))
            ->with('title', 'Музыкальные товары')
            ->with('query', $query ?? '')
            ->with('tableName', $this->tableName);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create')
            ->with('title', 'Добавить музыкальный товар')
            ->with('tableName', $this->tableName);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            if ($request->file('image')) {
                $product = Product::storeOrUpdate($request);
                if ($product === 'noCategory') {
                    return back()
                        ->withInput()
                        ->withErrors(['category' => 'Необходимо указать хотя бы одну категорию музыкальному товару']);
                }
                if ($product === 'noSpecification') {
                    return back()
                        ->withInput()
                        ->withErrors(['specification' => 'Необходимо указать хотя бы одну характеристику музыкальному товару']);
                }
                return redirect()->route('product.show', ['product' => $product]);
            }
            else {
                return back()
                    ->withInput()
                    ->withErrors(['image' => 'Необходимо загрузить изображение музыкальному товару']);
            }
        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1062) {
                if (str_contains($ex->getMessage(), 'products_name_unique')) {
                    return back()
                        ->withInput()
                        ->withErrors(['name' => 'Музыкальный товар с таким именем уже существует']);
                } else if (str_contains($ex->getMessage(), 'products_image_unique')) {
                    return back()
                        ->withInput()
                        ->withErrors(['image' => 'Музыкальный товар с таким изображением уже существует']);
                }
            }
//            return back()
//                ->withInput()
//                ->withErrors(['error' => $ex->getMessage()]);
        }
        return back()->withInput()->withErrors(['error' => 'Произошла ошибка сохранения товара']);
    }


    public function show(Product $product)
    {
        return view('product.show', compact('product'))
            ->with('title', '«' . $product->name . '»')
            ->with('tableName', $this->tableName);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'))
            ->with('title', 'Изменить «' . $product->name . '»')
            ->with('tableName', $this->tableName);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        try {
            $product = Product::storeOrUpdate($request, $product);
            if ($product === 'noCategory') {
                return back()
                    ->withInput()
                    ->withErrors(['category' => 'Необходимо указать хотя бы одну категорию музыкальному товару']);
            }
            if ($product === 'noSpecification') {
                return back()
                    ->withInput()
                    ->withErrors(['specification' => 'Необходимо указать хотя бы одну характеристику музыкальному товару']);
            }
            return redirect()->route('product.show', ['product' => $product]);
        } catch (QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1062) {
                if (str_contains($ex->getMessage(), 'products_name_unique')) {
                    return back()
                        ->withInput()
                        ->withErrors(['name' => 'Музыкальный товар с таким именем уже существует']);
                } else if (str_contains($ex->getMessage(), 'products_image_unique')) {
                    return back()
                        ->withInput()
                        ->withErrors(['image' => 'Музыкальный товар с таким изображением уже существует']);
                }
            }
        }
        return back()
            ->withInput()
            ->withErrors(['error' => 'Произошла ошибка сохранения товара']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            unlink(public_path('images/products/' . $product->image));
            $product->delete();
            return redirect()->route('product.index');
        }
        catch (QueryException) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Произошла ошибка удаления товара']);
        }
    }
}
