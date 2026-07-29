<?php

namespace Database\Seeders;

use App\Models\Category;
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
        $categories = Category::all()->keyBy('name');

        if ($categories->isEmpty()) {
            return;
        }

        $now = Carbon::now();

        $sampleTransactions = [
            // Current Month Incomes
            [
                'transaction_date' => $now->copy()->startOfMonth()->addDays(1)->format('Y-m-d'),
                'type' => 'income',
                'category_id' => $categories->get('Gaji')?->id,
                'amount' => 15500000.00,
                'description' => 'Gaji Bulanan Utama',
                'notes' => 'Transfer rekening utama',
            ],
            [
                'transaction_date' => $now->copy()->startOfMonth()->addDays(5)->format('Y-m-d'),
                'type' => 'income',
                'category_id' => $categories->get('Freelance')?->id,
                'amount' => 3500000.00,
                'description' => 'Projek Website Redesign',
                'notes' => 'Klien PT Maju Bersama',
            ],
            [
                'transaction_date' => $now->copy()->startOfMonth()->addDays(12)->format('Y-m-d'),
                'type' => 'income',
                'category_id' => $categories->get('Investasi')?->id,
                'amount' => 750000.00,
                'description' => 'Dividen Saham BBCA',
                'notes' => 'Dividen kuartal 2',
            ],
            [
                'transaction_date' => $now->copy()->subDays(2)->format('Y-m-d'),
                'type' => 'income',
                'category_id' => $categories->get('Cashback')?->id,
                'amount' => 125000.00,
                'description' => 'Cashback Promo Tokopedia',
                'notes' => 'Kupon belanja elektronik',
            ],

            // Current Month Expenses
            [
                'transaction_date' => $now->copy()->startOfMonth()->addDays(2)->format('Y-m-d'),
                'type' => 'expense',
                'category_id' => $categories->get('Tagihan')?->id,
                'amount' => 1200000.00,
                'description' => 'Sewa Apartemen / Kos',
                'notes' => 'Pembayaran rutin bulan ini',
            ],
            [
                'transaction_date' => $now->copy()->startOfMonth()->addDays(3)->format('Y-m-d'),
                'type' => 'expense',
                'category_id' => $categories->get('Listrik')?->id,
                'amount' => 450000.00,
                'description' => 'Token Listrik PLN',
                'notes' => 'Nomor meter 1403928172',
            ],
            [
                'transaction_date' => $now->copy()->startOfMonth()->addDays(4)->format('Y-m-d'),
                'type' => 'expense',
                'category_id' => $categories->get('Internet')?->id,
                'amount' => 380000.00,
                'description' => 'IndiHome 50Mbps',
                'notes' => 'Tagihan bulanan internet',
            ],
            [
                'transaction_date' => $now->copy()->startOfMonth()->addDays(7)->format('Y-m-d'),
                'type' => 'expense',
                'category_id' => $categories->get('Belanja')?->id,
                'amount' => 850000.00,
                'description' => 'Belanja Bulanan Supermarket',
                'notes' => 'Kebutuhan dapur & mandi',
            ],
            [
                'transaction_date' => $now->copy()->subDays(10)->format('Y-m-d'),
                'type' => 'expense',
                'category_id' => $categories->get('Makanan')?->id,
                'amount' => 145000.00,
                'description' => 'Makan Malam Resto Japanese',
                'notes' => 'Bersama teman kantor',
            ],
            [
                'transaction_date' => $now->copy()->subDays(7)->format('Y-m-d'),
                'type' => 'expense',
                'category_id' => $categories->get('Transportasi')?->id,
                'amount' => 250000.00,
                'description' => 'Isi Bensin Pertamax',
                'notes' => 'Full tank',
            ],
            [
                'transaction_date' => $now->copy()->subDays(5)->format('Y-m-d'),
                'type' => 'expense',
                'category_id' => $categories->get('Hiburan')?->id,
                'amount' => 180000.00,
                'description' => 'Tiket Bioskop IMAX & Popcorn',
                'notes' => 'Nonton film weekend',
            ],
            [
                'transaction_date' => $now->copy()->subDays(3)->format('Y-m-d'),
                'type' => 'expense',
                'category_id' => $categories->get('Minuman')?->id,
                'amount' => 45000.00,
                'description' => 'Kopi Artisan Latte',
                'notes' => 'Work from Cafe',
            ],
            [
                'transaction_date' => $now->copy()->subDays(1)->format('Y-m-d'),
                'type' => 'expense',
                'category_id' => $categories->get('Kesehatan')?->id,
                'amount' => 320000.00,
                'description' => 'Beli Vitamin & Suplemen',
                'notes' => 'Apotek K-24',
            ],
            [
                'transaction_date' => $now->format('Y-m-d'),
                'type' => 'expense',
                'category_id' => $categories->get('Makanan')?->id,
                'amount' => 55000.00,
                'description' => 'Makan Siang Nasi Padang',
                'notes' => 'Lauk ayam pop',
            ],
        ];

        foreach ($sampleTransactions as $data) {
            if ($data['category_id']) {
                Transaction::create($data);
            }
        }
    }
}
