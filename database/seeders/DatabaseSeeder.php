<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Raihan',
            'email' => 'raihan@gmail.com',
            'password' => Hash::make('raihan'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Tenizen Bank',
            'email' => 'bank@gmail.com',
            'password' => Hash::make('bank'),
            'role' => 'bank',
        ]);
        User::create([
            'name' => 'Tenizen Mart',
            'email' => 'kantin@gmail.com',
            'password' => Hash::make('kantin'),
            'role' => 'kantin',
        ]);

        Product::create([
            'name' => 'Nasi Goreng',
            'photo' => 'https://i.pinimg.com/736x/94/82/ab/9482ab2e248d249e7daa7fd6924c8d3b.jpg',
            'price' => 8000,
            'desc' => 'Nasi Goreng dengan tambahan telur',
            'stock' => 20,
        ]);
        Product::create([
            'name' => 'Es Jeruk',
            'photo' => 'https://i.pinimg.com/736x/bd/b9/69/bdb969ad8c1bd6de15ab757cc1d24c56.jpg',
            'price' => 5000,
            'desc' => 'Es dengan perasn jeruk peras',
            'stock' => 50,
        ]);
        Transaction::create([
            'user_id' => 1, 
            'product_id' => 1,
            'order_id' => 'ORD_123',
            'quantity' => 2, 
            'status' => 'dikeranjang', 
        ]);
        Transaction::create([
            'user_id' => 1, 
            'product_id' => 2, 
            'order_id' => 'ORD_123',
            'quantity' => 2, 
            'status' => 'dibayar', 
        ]);
        Transaction::create([
            'user_id' => 1, 
            'product_id' => 1, 
            'order_id' => 'ORD_124',
            'quantity' => 2, 
            'status' => 'diambil', 
        ]);

        Wallet::create([
            'user_id' => 1,
            'credit' => 100000,
            'status' => 'diterima',
            'desc' => 'Top Up',
        ]);
        Wallet::create([
            'user_id' => 1,
            'credit' => 30000,
            'status' => 'proses',
            'desc' => 'Top Up',
        ]);
        Wallet::create([
            'user_id' => 1,
            'debit' => 10000,
            'status' => 'diterima',
            'desc' => 'Membeli Barang',
        ]);
        Wallet::create([
            'user_id' => 1,
            'debit' => 10000,
            'status' => 'ditolak',
            'desc' => 'Top Up',
        ]);
        Wallet::create([
            'user_id' => 1,
            'debit' => 10000,
            'status' => 'proses',
            'desc' => 'Membeli Barang',
        ]);
    }
}
