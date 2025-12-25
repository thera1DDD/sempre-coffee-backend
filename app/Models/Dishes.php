<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dishes extends Model
{
    use HasFactory;
    protected $fillable =

        [
            'name',
            'description',
            'image',
            'ingredients',
            'kcal',
            'gram',
            'price',
            'category_id',
        ];

    public static function getCategoryWithDishesAndStats(int $categoryId)
    {
        $category = self::query()
            ->where('id', $categoryId)
            ->with([
                'dishes' => function ($query) {
                    $query->orderBy('price', 'asc');
                }
            ])
            ->withCount('dishes')
            ->withMin('dishes', 'price')
            ->withMax('dishes', 'price')
            ->firstOrFail();

        return [
            'id' => $category->id,
            'name' => $category->name,
            'description' => $category->description,
            'dishes_count' => $category->dishes_count,
            'min_price' => $category->dishes_min_price,
            'max_price' => $category->dishes_max_price,
            'dishes' => $category->dishes,
        ];
    }
}
