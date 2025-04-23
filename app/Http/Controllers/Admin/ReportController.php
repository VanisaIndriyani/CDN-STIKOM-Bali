<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $statistics = DB::table('alumni')
            ->select([
                DB::raw('COUNT(*) as total_alumni'),
                DB::raw('COUNT(CASE WHEN pekerjaan IS NOT NULL AND pekerjaan != "" THEN 1 END) as working_alumni'),
                DB::raw('COALESCE(COUNT(CASE WHEN relevansi = 1 THEN 1 END) * 100.0 / NULLIF(COUNT(*), 0), 0) as relevance_percentage')
            ])
            ->first();

        $yearlyData = DB::table('alumni')
            ->select([
                'tahun_lulus as year',
                DB::raw('COUNT(*) as total'),
                DB::raw('COUNT(CASE WHEN pekerjaan IS NOT NULL AND pekerjaan != "" THEN 1 END) as working'),
                DB::raw('COUNT(CASE WHEN relevansi = 1 THEN 1 END) as relevant')
            ])
            ->whereNotNull('tahun_lulus')
            ->groupBy('tahun_lulus')
            ->orderBy('tahun_lulus', 'desc')
            ->get();

        return view('admin.reports.index', compact('statistics', 'yearlyData'));
    }
}