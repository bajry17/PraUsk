<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->role == 'user'){
            $products = Product::all();
            $carts =Transaction::where('user_id', Auth::user()->id)->where('status','dikeranjang')->get();
            $wallets = Wallet::where('user_id', Auth::user()->id)->where('status','diterima')->get();
            $credit = 0;
            $debit = 0;
            foreach ($wallets as $wallet) {
                $credit += $wallet->credit;
                $debit += $wallet->debit;
                $saldo = $credit - $debit; 
            }
            return view('user.index', compact('products','saldo','carts'));
        }
        elseif(Auth::user()->role == 'bank'){
            $wallets = Wallet::where('status','proses')->get();
            $users= User::where('role','user')->get();
            return view('bank.index',compact('wallets','users'));
        }
        elseif(Auth::user()->role == 'kantin'){
            $products = Product::all();
            $accepts = Transaction::where('status','dibayar')->get();

            return view('kantin.index', compact('products','accepts'));
        }

    }
}
