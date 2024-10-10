<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(){
        $cat = Category::query()->get();
        return response()->json([
        'category' => $cat
        ]);
    }
    
}
