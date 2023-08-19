<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Specification;
use App\Models\Supplier;
use Illuminate\Http\Request;

class MainController extends Controller
{
    static public int $perPage = 10;

    static public function capitalizeFirstWord($string): string
    {
        return mb_strtoupper(mb_substr($string, 0, 1)) . mb_strtolower(mb_substr($string, 1));
    }

    public static function generateUniqueFileNameForProducts($file)
    {
        $extension = $file->getClientOriginalExtension();
        $newName = 'img_' . uniqid() . '.' . $extension;

        $destinationPath = public_path('images/products');
        $i = 1;
        while (file_exists($destinationPath . '/' . $newName)) {
            $newName = 'img_' . uniqid() . '_' . $i . '.' . $extension;
            $i++;
        }
        return $newName;
    }

    public function autocomplete(Request $request)
    {
        $query = $request->get('query');
        $name = $request->get('name');

        $result = collect();

        if ($name === 'price' && Product::where('name', $query)->first()) {
            return Product::where('name', $query)->first()->selling_price;
        }
        if (str_contains($name, 'manufacturer')) {
            $result = Manufacturer::select('name')
                ->where('name', 'LIKE', '%' . $query . '%')
                ->distinct()
                ->limit(5)
                ->get();
        } elseif (str_contains($name, 'category')) {
            $result = Category::select('name')
                ->where('name', 'LIKE', '%' . $query . '%')
                ->distinct()
                ->limit(5)
                ->get();
        } elseif (str_contains($name, 'specification')) {
            $result = Specification::select('name')
                ->where('name', 'LIKE', '%' . $query . '%')
                ->distinct()
                ->limit(5)
                ->get();
        } elseif (str_contains($name, 'product')) {
            $result = Product::select('name')
                ->where('name', 'LIKE', '%' . $query . '%')
                ->distinct()
                ->limit(5)
                ->get();
        } elseif (str_contains($name, 'supplier')) {
            $result = Supplier::select('name')
                ->where('name', 'LIKE', '%' . $query . '%')
                ->distinct()
                ->limit(5)
                ->get();
        }
        elseif (str_contains($name, 'email')) {
            $result = Client::select('email')
                ->where('email', 'LIKE', '%' . $query . '%')
                ->distinct()
                ->limit(5)
                ->get();
        }
        elseif (str_contains($name, 'country') || str_contains($name, 'region') || str_contains($name, 'city') ||
            str_contains($name, 'street') || str_contains($name, 'house') || str_contains($name, 'post_index')) {
            $result = Supplier::select($name)
                ->where($name, 'LIKE', '%' . $query . '%')
                ->distinct()
                ->union(
                    Client::select($name)
                        ->where($name, 'LIKE', '%' . $query . '%')
                        ->distinct()
                        ->limit(5)
                )
                ->union(
                    Manufacturer::select($name)
                        ->where($name, 'LIKE', '%' . $query . '%')
                        ->distinct()
                        ->limit(5)
                )
                ->limit(5)
                ->get();
        }

        return response()->json($result);
    }

}
