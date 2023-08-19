<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class OrderController extends MainController
{
    protected string $tableName = 'order';

    public function index(Request $request)
    {
        $query = $request->input('search');

        if ($request->has('client')) {
            $table = Order::search($request)
                ->where('client_id', $request->input('client'))
                ->orderBy('date', 'DESC')
                ->paginate(self::$perPage);
        } else {
            $table = Order::search($request)
                ->orderBy('date', 'DESC')
                ->paginate(self::$perPage);
        }


        if ($request->has('page')) {
            $page = intval($request->query('page'));
            if ($page < 1 || $page > $table->lastPage()) {
                abort(404);
            }
        }
        return view('order.index', compact('table'))
            ->with('title', 'Заказы')
            ->with('query', $query ?? '')
            ->with('tableName', $this->tableName);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('order.create')
            ->with('title', 'Добавить заказ')
            ->with('tableName', $this->tableName);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        try {
            $order = Order::storeOrUpdate($request);
//            return $order;
            if ($order === 'noProducts') {
                return back()
                    ->withInput()
                    ->withErrors(['category' => 'Необходимо указать хотя бы один товар в заказе']);
            }
            if ($order === 'productsNoExist') {
                return back()
                    ->withInput()
                    ->withErrors(['specification' => 'Указанные товары не существуют']);
            }
            if ($order === 'noQuantity') {
                return back()
                    ->withInput()
                    ->withErrors(['quantity' => 'Данного товара нет столько в наличии']);
            }

            return redirect()->route('order.show', $order);

        } catch (QueryException $ex) {
//            return back()
//                ->withInput()
//                ->withErrors(['error' => 'Произошла ошибка сохранения заказа']);
//            else {
                return back()
                    ->withInput()
                    ->withErrors(['error' => $ex->getMessage()]);
//            }
        }

    }


    public function show(Order $order)
    {
        return view('order.show', compact('order'))
            ->with('title', 'Заказ')
            ->with('tableName', $this->tableName);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return abort(404);
//        return view('order.edit', compact('order'))
//            ->with('title', 'Изменить заказ')
//            ->with('tableName', $this->tableName);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, Order $order)
    {
        return abort(404);
//        try {
//            $order = Order::storeOrUpdate($request, $order);
//            if ($order === 'noCategory') {
//                return back()
//                    ->withInput()
//                    ->withErrors(['category' => 'Необходимо указать хотя бы одну категорию музыкальному товару']);
//            }
//            if ($order === 'noSpecification') {
//                return back()
//                    ->withInput()
//                    ->withErrors(['specification' => 'Необходимо указать хотя бы одну характеристику музыкальному товару']);
//            }
//            return redirect()->route('order.show', ['order' => $order]);
//        } catch (QueryException $ex) {
//            $errorCode = $ex->errorInfo[1];
//            if ($errorCode == 1062) {
//                if (str_contains($ex->getMessage(), 'orders_name_unique')) {
//                    return back()
//                        ->withInput()
//                        ->withErrors(['name' => 'Музыкальный товар с таким именем уже существует']);
//                } else {
//                    return back()
//                        ->withInput()
//                        ->withErrors(['image' => 'Музыкальный товар с таким изображением уже существует']);
//                }
//            }
//        }
//        return back()
//            ->withInput()
//            ->withErrors(['error' => 'Произошла ошибка сохранения товара']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
//        unlink(public_path('images/orders/' . $order->image));
        $order->delete();
        return redirect()->route('order.index');
    }
}
