<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk cards
        $avgSalary = Alumni::whereNotNull('rata_rata_gaji')
                          ->where('rata_rata_gaji', '>', 0)
                          ->avg('rata_rata_gaji');

        $summary = [
            'total_alumni' => Alumni::count(),
            'employed' => Alumni::whereNotNull('pekerjaan')->count(),
            'avg_salary' => $avgSalary ?? 0,
            'avg_waiting_time' => 0 // Setting default value instead of querying non-existent column
        ];

        // Data untuk grafik berdasarkan bidang
        $jobFields = Alumni::select('bidang', DB::raw('count(*) as total'))
            ->whereNotNull('bidang')
            ->groupBy('bidang')
            ->get();

        // Data untuk grafik berdasarkan tahun lulus
        $yearlyStats = Alumni::select('tahun_lulus', DB::raw('count(*) as total'))
            ->groupBy('tahun_lulus')
            ->orderBy('tahun_lulus')
            ->get();

        // Menghapus bagian salaryRanges karena kolom 'gaji' tidak ada di database
        // Kamu bisa menambahkan query lain yang lebih relevan atau menghapus bagian ini
        $salaryRanges = []; // Menghapus data salaryRanges

        return view('user.dashboard', compact('summary', 'jobFields', 'yearlyStats', 'salaryRanges'));
    }
}
