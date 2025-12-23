<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function getCategories(){
        return Category::withDishesStats()->get();
    }

    public function getDishesByCategory($categoryId){
        return Category::getCategoryWithDishesAndStats($categoryId);
    }
}
