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
        // $transactions = Transaction::where('user_id', Auth::user()->id)->get();
        $transactions = Transaction::with('product','user')->where('user_id', Auth::user()->id)->latest()->get()->groupBy(function ($item){
            return $item->created_at->toDateString();
        });
        $wallets = Wallet::with('user')->where('user_id', Auth::user()->id)->latest()->get()->groupBy(function ($item){
            return $item->created_at->toDateString();
        });

        return view("user.riwayat", compact("transactions",'wallets'));
        }else{
            $transactions = Transaction::with('product','user')->latest()->get()->groupBy(function ($item){
                return $item->created_at->toDateString();
            });
            $wallets = Wallet::with('user')->latest()->get()->groupBy(function ($item){
                return $item->created_at->toDateString();
            });

            return view("kantin.riwayat", compact("transactions",'wallets'));
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

    public function transaksimantap() {
        dd('hello world');
    }

    public function AddToCart(Request $request)
    {
            $product_id = $request->product_id;
            $quantity = $request->quantity;
            $products = Product::where('id', $product_id)->get();
            foreach ($products as $product) {
                $stock = $product->stock;
            }
            // $transaction = Transaction::where('user_id', Auth::user()->id)->where('status','dikeranjang')->where('product_id',$product_id)->get();
            // foreach( $transaction as $ambil){
            //     $quantity = $ambil->quantity;
            // }

        if($stock < 0){
            return redirect()->back()->with('status','Stok Habis');
        }elseif($request->quantity > $stock){
            return redirect()->back()->with('status','Stok Kurang');
        }
        // elseif($transaction){
        //     $quantity += $request->quantity; 
        //     $transaction->save();
        // }
        $transaction = Transaction::where('user_id', Auth::user()->id)
            ->where('product_id', $product_id)
            ->where('status', 'dikeranjang')
            ->first();
            // dd($transaction);

        if($transaction) {
            // If the product is already in the cart, increase the quantity
            $all = $transaction->quantity += $quantity;
            if($stock < $all){
                return redirect()->back()->with('status', 'stok kurang');
            }else{
                $transaction->save();
                return redirect()->back()->with('status', 'Berhasil Add to Cart');
            }
        }
        else{   
            $cart = Transaction::create([
                'user_id' => $request->user_id,
                'product_id'=> $request->product_id,
                'quantity'=> $request->quantity,
            ]);
    
            return redirect()->back()->with('status','Masuk Keranjang');
        }
    }

    public function paynow(Request $request){
        $transactions = Transaction::where('status','dikeranjang')->get();          
            foreach ($transactions as $transaction) {
                $total = $transaction->quantity * $transaction->product->price;
                $stock = $transaction->product->stock;
                $product_id = $transaction->product->id;
                $id= $transaction->id;
            }   
            $wallets = Wallet::where('user_id', Auth::user()->id)->where('status','diterima')->get();
            $credit = 0;
            $debit = 0;
            foreach ($wallets as $wallet) {
                $credit += $wallet->credit;
                $debit += $wallet->debit;
                $saldo = $credit - $debit; 
            }
            if($transactions == null){
                return redirect()->back()->with('status','Keranjang kosong silahkan tambah keranjang');
            }else
            {

                if($saldo < $total)
                {
                    return redirect()->back()->with('status','Saldo Tidak Cukup');
                }
                else{
                    Wallet::create([
                        'user_id'=> Auth::user()->id,
                        'product_id'=> $product_id,
                        'debit' => $total,
                        'desc' => 'Membeli Barang',
                        'status' => 'diterima'
                    ]);
                    $waktu = date('YmdHis');
                    Transaction::find($id)->update([
                        'status' => 'dibayar',
                        'order_id' =>'ORD_'.$waktu,  
                    ]);
                    Product::find($product_id)->update([
                        'stock' => $stock - $request->quantity   
                    ]);       
                    return redirect()->back()->with('status','Berhasil dibayar');
                }
            }
    }

    public function accept(Request $request){
        Transaction::find($request->id)->update([
            'status' => 'diambil',
        ]);
        return redirect()->back()->with('status','Sudah Diambil');
    }
    
    public function downloadsingle($order_id){
        $reports = Transaction::where('order_id',$order_id)->latest()->get();
        $code = $order_id;
        $total = 0;         
        foreach ($reports as $report) {
            $total += $report->product->price * $report->quantity;
        } 
        return view('download', compact('reports','code','total'));
    }

    public function downloadharian($date){
        if(Auth::user()->role == 'user') {
            $reports = Transaction::latest()->with("product")->where('users_id', Auth::user()->id)->where('status','diambil')->whereDate("created_at", "=", $date)->get();
            $code = $date;
            $total = 0;
            foreach ($reports as $report) {
                $total += $report->product->price * $report->quantity;
            } 
        } else {
            $reports = Transaction::latest()->with("product")->where('status','diambil')->whereDate("created_at", "=", $date)->get();
            $code = $date;
            $total = 0;
            foreach ($reports as $report) {
                $total += $report->product->price * $report->quantity;
            } 
        }   


        return view('downloadharian', compact('reports', 'code','total'));

    }


}