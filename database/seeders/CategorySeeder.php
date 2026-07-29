<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $expenseCategories = [
            ['name' => 'Makanan', 'color' => '#EF4444', 'icon' => 'utensils'],
            ['name' => 'Minuman', 'color' => '#F97316', 'icon' => 'cup-hot'],
            ['name' => 'Transportasi', 'color' => '#F59E0B', 'icon' => 'car'],
            ['name' => 'Belanja', 'color' => '#10B981', 'icon' => 'shopping-bag'],
            ['name' => 'Tagihan', 'color' => '#3B82F6', 'icon' => 'receipt'],
            ['name' => 'Listrik', 'color' => '#6366F1', 'icon' => 'bolt'],
            ['name' => 'Air', 'color' => '#06B6D4', 'icon' => 'droplet'],
            ['name' => 'Internet', 'color' => '#8B5CF6', 'icon' => 'wifi'],
            ['name' => 'Kesehatan', 'color' => '#EC4899', 'icon' => 'heart'],
            ['name' => 'Pendidikan', 'color' => '#14B8A6', 'icon' => 'academic-cap'],
            ['name' => 'Hiburan', 'color' => '#D97706', 'icon' => 'film'],
            ['name' => 'Lainnya', 'color' => '#6B7280', 'icon' => 'folder'],
        ];

        foreach ($expenseCategories as $cat) {
            Category::firstOrCreate(
                ['name' => $cat['name'], 'type' => 'expense'],
                ['color' => $cat['color'], 'icon' => $cat['icon']]
            );
        }

        $incomeCategories = [
            ['name' => 'Gaji', 'color' => '#10B981', 'icon' => 'banknotes'],
            ['name' => 'Bonus', 'color' => '#059669', 'icon' => 'gift'],
            ['name' => 'Freelance', 'color' => '#3B82F6', 'icon' => 'laptop'],
            ['name' => 'Investasi', 'color' => '#8B5CF6', 'icon' => 'chart-bar'],
            ['name' => 'Penjualan', 'color' => '#F59E0B', 'icon' => 'tag'],
            ['name' => 'Cashback', 'color' => '#EC4899', 'icon' => 'sparkles'],
            ['name' => 'Lainnya', 'color' => '#6B7280', 'icon' => 'folder'],
        ];

        foreach ($incomeCategories as $cat) {
            Category::firstOrCreate(
                ['name' => $cat['name'], 'type' => 'income'],
                ['color' => $cat['color'], 'icon' => $cat['icon']]
            );
        }
    }
}
