<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Produk;
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
        $totalPengguna = User::count();
        $transaksiBerhasil = Transaction::count();
        $totalProduk = Produk::count();
        return view('homepage.index', [
            'totalPengguna' => $totalPengguna,
            'transaksiBerhasil' => $transaksiBerhasil,
            'totalProduk' => $totalProduk,
        ]);
    }
}
