<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->role == 'user'){
        $transactions = Transaction::where('user_id', Auth::user()->id)->get();
        $wallets = Wallet::where('user_id', Auth::user()->id)->get();
        $quantity = 0;
        $price = 0;
        foreach ($transactions as $transaction) {
            $total = $transaction->quantity * $transaction->product->price;
        }

        return view("user.riwayat", compact("transactions",'total','wallets'));
        }elseif(Auth::user()->role == 'kantin'){
            $wallets = Wallet::all();
            $transactions = Transaction::all();
            $quantity = 0;
            $price = 0;
            foreach ($transactions as $transaction) {
                $total = $transaction->quantity * $transaction->product->price;
            }

            return view("kantin.riwayat", compact("transactions",'total','wallets'));
        }
        elseif(Auth::user()->role == 'bank'){
            $transactions = Transaction::all();
            $wallets = Wallet::all();
            $quantity = 0;
            $price = 0;
            foreach ($transactions as $transaction) {
                $total = $transaction->quantity * $transaction->product->price;
            }

                return view("kantin.riwayat", compact("transactions",'total','wallets'));
                }   
    }    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        Transaction::find($transaction->id)->delete();

        return redirect()->back()->with('status','Barang dihapus dari Keranjang');

    }

    public function AddToCart(Request $request)
    {
            $product_id = $request->product_id;
            $products = Product::where('id', $product_id)->get();
            foreach ($products as $product) {
                $stock = $product->stock;
            }

        if($stock < 0){
            return redirect()->back()->with('status','Stok Habis');
        }
        else{   
            $waktu = date('YmdHis');
            $cart = Transaction::create([
                'user_id' => $request->user_id,
                'product_id'=> $request->product_id,
                'quantity'=> $request->quantity,
                'order_id' =>'ORD_'.$waktu,
            ]);
    
            return redirect()->back()->with('status','Masuk Keranjang');
        }
    }

    public function paynow(Request $request){
        $transactions = Transaction::where('id', $request->id)->where('status','dikeranjang')->get();
            foreach ($transactions as $transaction) {
                $total = $transaction->quantity * $transaction->product->price;
                $stock = $transaction->product->stock;
            }   
            $wallets = Wallet::where('user_id', Auth::user()->id)->where('status','diterima')->get();
            $credit = 0;
            $debit = 0;
            foreach ($wallets as $wallet) {
                $credit += $wallet->credit;
                $debit += $wallet->debit;
                $saldo = $credit - $debit; 
            }
            if($saldo < $total)
            {
                return redirect()->back()->with('status','Saldo Tidak Cukup');
            }
            else{
                Wallet::create([
                    'user_id'=> Auth::user()->id,
                    'product_id'=> $request->product_id,
                    'debit' => $total,
                    'desc' => 'Membeli Barang',
                    'status' => 'diterima'
                ]);
                Transaction::find($request->id)->update([
                    'status' => 'dibayar'
                ]);
                Product::find($request->product_id)->update([
                    'stock' => $stock - $request->quantity   
                ]);       
                return redirect()->back()->with('status','Berhasil dibayar');
            }
    }
    public function accept(Request $request){
        Transaction::find($request->id)->update([
            'status' => 'diambil'
        ]);
        return redirect()->back()->with('status','Sudah Diambil');
    }
    


}
