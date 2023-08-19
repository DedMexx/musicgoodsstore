<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Manufacturer;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Collection;

class ReportController extends MainController
{
    public function salesByCategory(Request $request)
    {
        $table = Category::sales($request)
            ->paginate(self::$perPage);
        if ($request->has('page')) {
            $page = intval($request->query('page'));
            if ($page < 1 || $page > $table->lastPage()) {
                abort(404);
            }
        }
        return view('report.salesByCategory', compact('table'))
            ->with('title', 'Отчет продаж по категориям')
            ->with('tableName', 'salesByCategory')
            ->with('query', $request->input('search') ?? '');
    }

    public function salesByManufacturer(Request $request)
    {
        $table = Manufacturer::sales($request)
            ->paginate(self::$perPage);
        if ($request->has('page')) {
            $page = intval($request->query('page'));
            if ($page < 1 || $page > $table->lastPage()) {
                abort(404);
            }
        }
        return view('report.salesByManufacturer', compact('table'))
            ->with('title', 'Отчет продаж по производителям')
            ->with('tableName', 'salesByManufacturer')
            ->with('query', $request->input('search') ?? '');
    }

    public function salesByPeriod(Request $request)
    {
        $totalCost = 0;
        $totalPaid = 0;
        $totalCount = 0;

        $table = Order::search($request)
            ->orderBy('date')
            ->get();

        foreach ($table as $item) {
            $totalCost+=$item->cost;
            $totalPaid+=$item->paid;
            $totalCount+=$item->count;
        }
//        if ($request->has('page')) {
//            $page = intval($request->query('page'));
//            if ($page < 1 || $page > $table->lastPage()) {
//                abort(404);
//            }
//        }
        return view('report.salesByPeriod', compact('table'))
            ->with('title', 'Отчет продаж за период')
            ->with('tableName', 'salesByPeriod')
            ->with('totalCost', $totalCost)
            ->with('totalPaid', $totalPaid)
            ->with('totalCount', $totalCount);
    }

    public function inventory()
    {
        return view('report.salesByCategory')
            ->with('title', 'Отчет по товарам в наличии');
    }

    public function customerOrders()
    {
        return view('report.salesByCategory')
            ->with('title', 'Отчет по заказам клиентов');
    }

    public function supplies()
    {
        return view('report.salesByCategory')
            ->with('title', 'Отчет по поставкам');
    }

    public function tbr(Request $request)
    {
        $table = [];
        $balance = 0; // Баланс доходов и расходов

        // Расходы
        $costs = InvoiceProduct::getCostsByDate($request);
        //Доходы
        $incomes = Payment::getPaymentsByDate($request);

        // Добавление в общий массив и сортировка
        foreach ($costs as $cost) {
            $table[] = $cost;
            $balance -= $cost->cost_per_day;
        }
        foreach ($incomes as $income) {
            $table[] = $income;
            $balance += $income->income_per_day;
        }
        // Сортировка по дате
        usort($table, function ($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });
        $table = collect($table);

        // Добавление пагинации
        $table = new LengthAwarePaginator(
            $table->forPage(Paginator::resolveCurrentPage(), self::$perPage),
            $table->count(),
            self::$perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );

//        if ($request->has('page')) {
//            $page = intval($request->query('page'));
//            if ($page < 1 || $page > $table->lastPage()) {
//                abort(404);
//            }
//        }
        return view('report.tbr', compact('table'))
            ->with('title', 'Оборотно-сальдовая ведомость')
            ->with('tableName', 'tbr')
            ->with('query', $request->input('search') ?? '')
            ->with('balance', $balance);
    }

    public function profit(Request $request) {
        $table = Product::getProfit($request)
            ->get();
//            ->paginate(self::$perPage);
//        return $table;

        return view('report.profit', compact('table'))
            ->with('title', 'Отчет по прибыли')
            ->with('tableName', 'profit')
            ->with('query', $request->input('search') ?? '');
    }
}
