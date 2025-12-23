<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable =

        [
            'name',
            'description',
            'image',
        ];


    public function dishes(){
        return $this->hasMany(Dishes::class,'category_id');
    }

    public static function withDishesStats()
    {
        return self::query()
            ->withCount('dishes')
            ->withMin('dishes', 'price');
    }

    // App\Models\Category.php

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
