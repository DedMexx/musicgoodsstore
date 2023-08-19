<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecificationProduct extends Model
{
    use HasFactory;

    /**
     * Добавление товару новых характеристик и их значение
     * А также удаление, если поле стерли (оставили пустым)
     */
    static public function changeProductsSpecifications($request, $product)
    {
        $filteredSpecificationLabelsNames = preg_grep('/^specification_\d+_label$/', array_keys($request->all()));
        $filteredSpecificationValuesNames = preg_grep('/^specification_\d+$/', array_keys($request->all()));

        $specificationLabelsValues = array_filter(array_map(function ($key) use ($request) {
            return $request->get($key);
        }, $filteredSpecificationLabelsNames));

        $specificationValues = array_filter(array_map(function ($key) use ($request) {
            return $request->get($key);
        }, $filteredSpecificationValuesNames));

        SpecificationProduct::where('product_id', $product->id)->delete();

        foreach ($specificationLabelsValues as $key => $specificationName) {
            $specification = Specification::where('name', $specificationName)->first();
            if (!$specification) {
                $specification = new Specification;
                $specification->name = $specificationName;
                $specification->save();
            }
            $specificationProduct = new SpecificationProduct;
            $specificationProduct->product_id = $product->id;
            $specificationProduct->specification_id = $specification->id;
            $specificationProduct->value = $specificationValues[$key + 1];
            $specificationProduct->save();
        }
    }

    static public function makeDefault()
    {
        $sp = new SpecificationProduct;
        $sp->product_id = 1;
        $sp->specification_id = 12;
        $sp->value = '1.46 кг';
        $sp->save();

        $sp = new SpecificationProduct;
        $sp->product_id = 1;
        $sp->specification_id = 11;
        $sp->value = '120 См на 60 См';
        $sp->save();

        $sp = new SpecificationProduct;
        $sp->product_id = 1;
        $sp->specification_id = 13;
        $sp->value = 'Ольха';
        $sp->save();

        $sp = new SpecificationProduct;
        $sp->product_id = 1;
        $sp->specification_id = 17;
        $sp->value = 'Стальные';
        $sp->save();
    }
}
