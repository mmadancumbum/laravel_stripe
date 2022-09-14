<?php

namespace App\Http\Controllers;
use App\Models\Products;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products['products'] = Products::all();
        return view('products_list', $products);
        //return view('home');
    }
}
