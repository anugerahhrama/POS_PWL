<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function food_beverage(){
        return view('products.food_beverage');
    }

    public function beauty_health(){
        return view('products.beauty_health');
    }

    public function home_care(){
        return view('products.home_care');
    }

    public function baby_kid(){
        return view('products.baby_kid');
    }
}
