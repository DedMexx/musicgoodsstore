<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;

    static public function changeProductsCategories($request, $product)
    {
        $filteredCategoriesNames = preg_grep('/^category_\d+$/', array_keys($request->all()));

        $categoriesValues = array_filter(array_map(function ($key) use ($request) {
            return $request->get($key);
        }, $filteredCategoriesNames));

        CategoryProduct::where('product_id', $product->id)->delete();

        if (count($categoriesValues) > 0) {
            foreach ($categoriesValues as $categoryName) {
                $category = Category::where('name', $categoryName)->first();
                if (!$category) {
                    $category = new Category;
                    $category->name = $categoryName;
                    $category->save();
                }
                $categoryProduct = new CategoryProduct;
                $categoryProduct->product_id = $product->id;
                $categoryProduct->category_id = $category->id;
                $categoryProduct->save();
            }
        }
    }

    static public function makeDefault() {
        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 1;
        $ctgprd->category_id = 1;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 2;
        $ctgprd->category_id = 1;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 3;
        $ctgprd->category_id = 1;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 4;
        $ctgprd->category_id = 5;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 5;
        $ctgprd->category_id = 6;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 6;
        $ctgprd->category_id = 1;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 7;
        $ctgprd->category_id = 1;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 8;
        $ctgprd->category_id = 2;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 8;
        $ctgprd->category_id = 3;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 9;
        $ctgprd->category_id = 26;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 10;
        $ctgprd->category_id = 18;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 11;
        $ctgprd->category_id = 18;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 12;
        $ctgprd->category_id = 13;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 13;
        $ctgprd->category_id = 13;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 14;
        $ctgprd->category_id = 14;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 15;
        $ctgprd->category_id = 17;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 16;
        $ctgprd->category_id = 6;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 18;
        $ctgprd->category_id = 13;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 31;
        $ctgprd->category_id = 6;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 26;
        $ctgprd->category_id = 1;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 23;
        $ctgprd->category_id = 14;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 25;
        $ctgprd->category_id = 1;
        $ctgprd->save();

        $ctgprd = new CategoryProduct;
        $ctgprd->product_id = 25;
        $ctgprd->category_id = 4;
        $ctgprd->save();
    }
}
