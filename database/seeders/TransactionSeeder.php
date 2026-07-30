<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $sampleTransactions = [
            // Current Month Incomes
            [
                'transaction_date' => $now->copy()->startOfMonth()->addDays(1)->format('Y-m-d'),
                'type' => 'income',
                'category' => 'Gaji',
                'amount' => 15500000.00,
                'description' => 'Gaji Bulanan Utama',
                'notes' => 'Transfer rekening utama',
            ],
            [
                'transaction_date' => $now->copy()->startOfMonth()->addDays(5)->format('Y-m-d'),
                'type' => 'income',
                'category' => 'Freelance',
                'amount' => 3500000.00,
                'description' => 'Projek Website Redesign',
                'notes' => 'Klien PT Maju Bersama',
            ],
            [
                'transaction_date' => $now->copy()->startOfMonth()->addDays(12)->format('Y-m-d'),
                'type' => 'income',
                'category' => 'Investasi',
                'amount' => 750000.00,
                'description' => 'Dividen Saham BBCA',
                'notes' => 'Dividen kuartal 2',
            ],
            [
                'transaction_date' => $now->copy()->subDays(2)->format('Y-m-d'),
                'type' => 'income',
                'category' => 'Cashback',
                'amount' => 125000.00,
                'description' => 'Cashback Promo Tokopedia',
                'notes' => 'Kupon belanja elektronik',
            ],

            // Current Month Expenses
            [
                'transaction_date' => $now->copy()->startOfMonth()->addDays(2)->format('Y-m-d'),
                'type' => 'expense',
                'category' => 'Tagihan & Utilitas',
                'amount' => 1200000.00,
                'description' => 'Sewa Apartemen / Kos',
                'notes' => 'Pembayaran rutin bulan ini',
            ],
            [
                'transaction_date' => $now->copy()->startOfMonth()->addDays(3)->format('Y-m-d'),
                'type' => 'expense',
                'category' => 'Tagihan & Utilitas',
                'amount' => 450000.00,
                'description' => 'Token Listrik PLN',
                'notes' => 'Nomor meter 1403928172',
            ],
            [
                'transaction_date' => $now->copy()->startOfMonth()->addDays(4)->format('Y-m-d'),
                'type' => 'expense',
                'category' => 'Tagihan & Utilitas',
                'amount' => 380000.00,
                'description' => 'IndiHome 50Mbps',
                'notes' => 'Tagihan bulanan internet',
            ],
            [
                'transaction_date' => $now->copy()->startOfMonth()->addDays(7)->format('Y-m-d'),
                'type' => 'expense',
                'category' => 'Belanja & Groceries',
                'amount' => 850000.00,
                'description' => 'Belanja Bulanan Supermarket',
                'notes' => 'Kebutuhan dapur & mandi',
            ],
            [
                'transaction_date' => $now->copy()->subDays(10)->format('Y-m-d'),
                'type' => 'expense',
                'category' => 'Makanan & Minuman',
                'amount' => 145000.00,
                'description' => 'Makan Malam Resto Japanese',
                'notes' => 'Bersama teman kantor',
            ],
            [
                'transaction_date' => $now->copy()->subDays(7)->format('Y-m-d'),
                'type' => 'expense',
                'category' => 'Transportasi',
                'amount' => 250000.00,
                'description' => 'Isi Bensin Pertamax',
                'notes' => 'Full tank',
            ],
            [
                'transaction_date' => $now->copy()->subDays(5)->format('Y-m-d'),
                'type' => 'expense',
                'category' => 'Hiburan & Gaya Hidup',
                'amount' => 180000.00,
                'description' => 'Tiket Bioskop IMAX & Popcorn',
                'notes' => 'Nonton film weekend',
            ],
            [
                'transaction_date' => $now->copy()->subDays(3)->format('Y-m-d'),
                'type' => 'expense',
                'category' => 'Makanan & Minuman',
                'amount' => 45000.00,
                'description' => 'Kopi Artisan Latte',
                'notes' => 'Work from Cafe',
            ],
            [
                'transaction_date' => $now->copy()->subDays(1)->format('Y-m-d'),
                'type' => 'expense',
                'category' => 'Kesehatan',
                'amount' => 320000.00,
                'description' => 'Beli Vitamin & Suplemen',
                'notes' => 'Apotek K-24',
            ],
            [
                'transaction_date' => $now->format('Y-m-d'),
                'type' => 'expense',
                'category' => 'Makanan & Minuman',
                'amount' => 55000.00,
                'description' => 'Makan Siang Nasi Padang',
                'notes' => 'Lauk ayam pop',
            ],
        ];

        foreach ($sampleTransactions as $data) {
            Transaction::create($data);
        }
    }
}
