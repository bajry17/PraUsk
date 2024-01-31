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
            $transactions = Transaction::where('user_id', Auth::user()->id)->orderBy('created_at','DESC')->paginate(5)->groupBy('order_id');
            $keranjang = Transaction::where('status','dikeranjang')->get();      
            $credit = 0;
            $debit = 0;
            $saldo = 0;
            $total = 0;
            foreach ($wallets as $wallet) {
                $credit += $wallet->credit;
                $debit += $wallet->debit;
                $saldo = $credit - $debit; 
            }
            foreach ($transactions as $transaction) {
                $total = $transaction[0]->quantity * $transaction[0]->product->price;
            }
            return view('user.index', compact('products','saldo','carts','total','keranjang'));
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
