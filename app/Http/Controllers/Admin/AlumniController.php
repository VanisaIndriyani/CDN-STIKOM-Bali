<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AlumniImport;
use App\Exports\AlumniExport;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumni::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('nim', 'LIKE', "%{$search}%")
                  ->orWhere('pekerjaan', 'LIKE', "%{$search}%")
                  ->orWhere('perusahaan', 'LIKE', "%{$search}%")
                  ->orWhere('bidang', 'LIKE', "%{$search}%");
            });
        }

        $alumni = $query->paginate(10);
        
        return view('admin.alumni.index', compact('alumni'));
    }

    public function edit(Alumni $alumni)
    {
        return view('admin.alumni.edit', compact('alumni'));
    }

    public function update(Request $request, Alumni $alumni)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:alumni,nim,' . $alumni->id,
            'tahun_lulus' => 'required|numeric',
            'pekerjaan' => 'nullable',
            'perusahaan' => 'nullable',
            'bidang' => 'nullable',
            'relevansi' => 'nullable|boolean'
        ]);

        $alumni->update($validated);

        return redirect()->route('admin.alumni.index')
            ->with('success', 'Data alumni berhasil diperbarui');
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv'
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $spreadsheet = IOFactory::load($file);
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();

                // Skip header row
                array_shift($rows);

                DB::beginTransaction();

                foreach ($rows as $row) {
                    if (!empty($row[0]) && !empty($row[1])) { // Check if nama and nim exist
                        Alumni::create([
                            'nama' => trim($row[0]),
                            'nim' => trim($row[1]),
                            'tahun_lulus' => !empty($row[2]) ? intval($row[2]) : null,
                            'periode_wisuda' => trim($row[4] ?? ''),
                            'tahun_yudisium' => !empty($row[3]) ? intval($row[3]) : null,
                            'pekerjaan' => trim($row[5] ?? ''),
                            'perusahaan' => trim($row[6] ?? ''),
                            'bidang' => trim($row[7] ?? ''),
                            'relevansi' => !empty($row[8]) ? 1 : 0
                        ]);
                    }
                }

                DB::commit();
                return redirect()->route('admin.alumni.index')
                    ->with('success', 'Data alumni berhasil diimpor');
            }
    
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }
    

    public function export()
    {
        $alumni = Alumni::all();
        $filename = 'alumni_' . date('Y-m-d_H-i-s') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        
        // Write headers
        fputcsv($output, ['Nama', 'NIM', 'Tahun Lulus', 'Tahun Yudisium', 'Periode Wisuda', 'Pekerjaan', 'Perusahaan', 'Bidang', 'Relevansi']);

        // Write data
        foreach ($alumni as $alum) {
            fputcsv($output, [
                $alum->nama,
                $alum->nim,
                $alum->tahun_lulus,
                $alum->tahun_yudisium,
                $alum->periode_wisuda,
                $alum->pekerjaan,
                $alum->perusahaan,
                $alum->bidang,
                $alum->relevansi
            ]);
        }

        fclose($output);
        exit;
    }

    public function destroy($id)
{
    $alumni = Alumni::findOrFail($id);
    $alumni->delete();

    return response()->json(['success' => true]);
}
}
