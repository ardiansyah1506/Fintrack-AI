<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prompt;
use App\Models\AiMemory;

class PromptAndMemorySeeder extends Seeder
{
    /**
     * Run the database seeds for Prompts and AI Memories.
     */
    public function run(): void
    {
        // 1. Seed Prompts
        $prompts = [
            [
                'name' => 'Telegram Intent Parser & Financial Extraction',
                'prompt' => "Kamu adalah FinTrack AI Natural Language Parser. Tugasmu adalah menganalisis pesan finansial pengguna dari Telegram dan mengekstrak Intent serta Parameter ke dalam format JSON baku.\nFormat output JSON wajib:\n{\n  \"intent\": \"create_transaction|create_budget|create_bill|create_reminder|statistics|help\",\n  \"parameters\": {\n    \"type\": \"income|expense\",\n    \"amount\": 50000,\n    \"category\": \"Makanan\",\n    \"description\": \"Detail catatan\"\n  }\n}",
                'active' => true,
                'version' => 1,
            ],
            [
                'name' => 'Personal Finance Advisory & Insight Engine',
                'prompt' => "Kamu adalah FinTrack AI Personal Advisor. Berdasarkan riwayat transaksi, anggaran, dan saldo pengguna, berikan rekomendasi keuangan yang taktis, ramah, dan berbasis data. Selalu dorong pengguna untuk mengalokasikan minimal 20% pendapatan ke tabungan atau dana darurat.",
                'active' => true,
                'version' => 2,
            ],
            [
                'name' => 'Cashflow Prediction & Anomaly Warning Prompt',
                'prompt' => "Kamu adalah AI Warning & Prediction Engine. Analisis pola pengeluaran bulanan pengguna. Jika terjadi kenaikan pengeluaran berlebih di kategori tak terduga (misal Hobi atau Hiburan > 40%), hasilkan pesan peringatan tingkat tinggi (High Severity) beserta langkah mitigasi.",
                'active' => true,
                'version' => 1,
            ],
            [
                'name' => 'Saving Goal Motivational Coach Prompt',
                'prompt' => "Kamu adalah Motivational Coach untuk FinTrack AI Saving Goals. Berikan apresiasi dan lencana pencapaian (Badge Achievement) setiap kali pengguna berhasil menyetor saldo ke target tabungan mereka.",
                'active' => true,
                'version' => 1,
            ],
            [
                'name' => 'Monthly Financial Summary Generator Prompt',
                'prompt' => "Hasilkan ringkasan naratif laporan bulanan yang mencakup total pemasukan, total pengeluaran, persentase efisiensi anggaran, serta top 3 kategori pengeluaran terbesar dalam format markdown yang rapi.",
                'active' => false,
                'version' => 1,
            ]
        ];

        foreach ($prompts as $p) {
            Prompt::updateOrCreate(
                ['name' => $p['name']],
                $p
            );
        }

        // 2. Seed AI Memories (Context Vector Database)
        $memories = [
            [
                'key' => 'user_financial_goal',
                'value' => 'Membeli rumah impian seharga Rp 500 Juta dalam jangka waktu 5 tahun.',
                'type' => 'goal',
                'active' => true,
            ],
            [
                'key' => 'preferred_saving_ratio',
                'value' => '30% dari total pendapatan bersih bulanan.',
                'type' => 'preference',
                'active' => true,
            ],
            [
                'key' => 'monthly_target_income',
                'value' => 'Rp 25.000.000 per bulan dari Gaji & Side Income.',
                'type' => 'profile',
                'active' => true,
            ],
            [
                'key' => 'favorite_expense_category',
                'value' => 'Makanan & Minuman (Kuliner akhir pekan).',
                'type' => 'preference',
                'active' => true,
            ],
            [
                'key' => 'budget_alert_threshold',
                'value' => '85% dari batas maksimal anggaran bulanan.',
                'type' => 'threshold',
                'active' => true,
            ],
            [
                'key' => 'risk_tolerance_profile',
                'value' => 'Moderatif - Konservatif (Lebih menyukai alokasi di instrumen aman).',
                'type' => 'profile',
                'active' => true,
            ],
            [
                'key' => 'investment_preference',
                'value' => 'Reksadana Pasar Uang, Obligasi Negara (SBN), dan Deposito Syariah.',
                'type' => 'preference',
                'active' => true,
            ],
            [
                'key' => 'emergency_fund_target',
                'value' => 'Rp 50.000.000 (Setara dengan 6 kali estimasi pengeluaran bulanan).',
                'type' => 'goal',
                'active' => true,
            ],
            [
                'key' => 'primary_currency',
                'value' => 'IDR (Rupiah Indonesia)',
                'type' => 'rule',
                'active' => true,
            ],
            [
                'key' => 'auto_reminder_frequency',
                'value' => 'Harian setiap jam 08:00 WIB dan H-3 sebelum tanggal jatuh tempo tagihan.',
                'type' => 'rule',
                'active' => true,
            ],
        ];

        foreach ($memories as $m) {
            AiMemory::updateOrCreate(
                ['key' => $m['key']],
                $m
            );
        }
    }
}
