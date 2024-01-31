<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $wallets = Wallet::with('user')->where('user_id', Auth::user()->id)->latest()->get()->groupBy(function ($item){
        //     return $item->created_at->toDateString();
        // });
        $transactions = Wallet::with('user')->where('user_id', Auth::user()->id)->latest()->get()->groupBy(function ($item){
            return $item->created_at->toDateString();
        });
        // $wallets = Wallet::get();

        return view('user.riwayat', compact('wallets'));
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
    public function show(Wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
    public function TopUp(Request $request){
        Wallet::create($request->all());    

        return redirect()->back();
    }
    public function acceptsaldo(Request $request){
        Wallet::find($request->id)->update([
            'status' => 'diterima'
        ]);
        return redirect()->back()->with('status','Sudah Diambil');
    } 
    public function cancelsaldo(Request $request){
        Wallet::find($request->id)->update([
            'status' => 'ditolak'
        ]);
        return redirect()->back()->with('status','Sudah Diambil');
    }             
}   
