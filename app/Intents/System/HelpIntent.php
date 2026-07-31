<?php
namespace App\Intents\System;
use App\Intents\Contracts\IntentInterface;
class HelpIntent implements IntentInterface {
    public function handle(array $params): array {
        return [
            'intent' => 'help',
            'available_intents' => [
                'create_transaction' => 'Mencatat transaksi baru',
                'update_transaction' => 'Memperbarui transaksi',
                'delete_transaction' => 'Menghapus transaksi',
                'statistics' => 'Mengambil statistik ringkas keuangan',
                'daily_report' => 'Mengambil laporan harian',
                'weekly_report' => 'Mengambil laporan mingguan',
                'monthly_report' => 'Mengambil laporan bulanan',
                'budget' => 'Melihat ringkasan saldo & kas',
                'create_reminder' => 'Membuat pengingat',
                'create_bill' => 'Membuat tagihan rutin',
                'create_budget' => 'Membuat batas anggaran bulanan',
                'create_saving_goal' => 'Membuat target tabungan',
                'help' => 'Menampilkan daftar intent bot',
            ],
        ];
    }
}