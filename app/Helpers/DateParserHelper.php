<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateParserHelper
{
    /**
     * Parses a string period into a start and end Carbon date array.
     * Supports relative strings (today, this_week, etc), month names (juni), and month+year (juni 2026).
     * 
     * @param string $period
     * @return array [Carbon $start, Carbon $end] or null if invalid
     */
    public static function parsePeriod(?string $period): ?array
    {
        if (empty($period)) {
            return null;
        }

        $now = Carbon::now();
        $period = strtolower(trim($period));

        switch ($period) {
            case 'today':
            case 'daily':
            case 'harian':
                return [$now->copy()->startOfDay(), $now->copy()->endOfDay()];
            
            case 'yesterday':
                $yesterday = $now->copy()->subDay();
                return [$yesterday->copy()->startOfDay(), $yesterday->copy()->endOfDay()];
                
            case 'this_week':
            case 'weekly':
            case 'mingguan':
                return [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()];
                
            case 'last_week':
                $lastWeek = $now->copy()->subWeek();
                return [$lastWeek->copy()->startOfWeek(), $lastWeek->copy()->endOfWeek()];
                
            case 'this_month':
            case 'monthly':
            case 'bulanan':
                return [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()];
                
            case 'last_month':
                $lastMonth = $now->copy()->subMonth();
                return [$lastMonth->copy()->startOfMonth(), $lastMonth->copy()->endOfMonth()];
                
            case 'this_year':
            case 'tahunan':
                return [$now->copy()->startOfYear(), $now->copy()->endOfYear()];
                
            case 'last_year':
                $lastYear = $now->copy()->subYear();
                return [$lastYear->copy()->startOfYear(), $lastYear->copy()->endOfYear()];
        }

        // Parse indonesian month names
        $months = [
            'januari' => 1, 'februari' => 2, 'maret' => 3, 'april' => 4,
            'mei' => 5, 'juni' => 6, 'juli' => 7, 'agustus' => 8,
            'september' => 9, 'oktober' => 10, 'november' => 11, 'desember' => 12,
            // fallbacks
            'january' => 1, 'february' => 2, 'march' => 3, 'may' => 5,
            'june' => 6, 'july' => 7, 'august' => 8, 'october' => 10, 'december' => 12
        ];

        // Format: "juni 2026" or "juni"
        $parts = explode(' ', $period);
        $monthStr = $parts[0] ?? '';
        $yearStr = $parts[1] ?? '';

        if (array_key_exists($monthStr, $months)) {
            $monthNum = $months[$monthStr];
            $yearNum = is_numeric($yearStr) && strlen($yearStr) === 4 ? (int) $yearStr : $now->year;
            
            $targetMonth = Carbon::create($yearNum, $monthNum, 1);
            return [$targetMonth->copy()->startOfMonth(), $targetMonth->copy()->endOfMonth()];
        }
        
        // As a fallback for "6" or "12"
        if (is_numeric($monthStr) && $monthStr >= 1 && $monthStr <= 12) {
            $yearNum = is_numeric($yearStr) && strlen($yearStr) === 4 ? (int) $yearStr : $now->year;
            
            $targetMonth = Carbon::create($yearNum, (int)$monthStr, 1);
            return [$targetMonth->copy()->startOfMonth(), $targetMonth->copy()->endOfMonth()];
        }

        return null;
    }
}
