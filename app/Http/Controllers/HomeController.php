<?php

namespace App\Http\Controllers;

use App\Dish;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $isAdmin = false;
        $token = null;
        if (Auth::user()) {
            $isAdmin = Auth::user()->isAdministrator();
            $token = Auth::user()->api_token;
        }
        return view('home', ['isAdmin' => $isAdmin, 'token' => $token]);
    }

    public function productInfo(Dish $dish) {
        $isAdmin = false;
        $token = null;
        if (Auth::user()) {
            $isAdmin = Auth::user()->isAdministrator();
            $token = Auth::user()->api_token;
        }
        return view('pages.product', ['productId' => $dish->id, 'isAdmin' => $isAdmin, 'token' => $token]);
    }
}
