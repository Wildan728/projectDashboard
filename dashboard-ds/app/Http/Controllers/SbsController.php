<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SbsController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input search dari form
        $search = $request->input('search');

        // Query ke tabel + search jika ada input
        $ds_digipos_sbs = DB::table('ds_digipos_sbs')
            ->when($search, function ($query, $search) {
                $query->where('branch', 'like', "%{$search}%")
                    ->orWhere('mitra_sbp', 'like', "%{$search}%")
                    ->orWhere('cluster', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('nama_direct_sales', 'like', "%{$search}%")
                    ->orWhere('user_id', 'like', "%{$search}%");
            })
            ->paginate(10);

        // Agar tetap membawa keyword search saat pindah halaman
        $ds_digipos_sbs->appends(['search' => $search]);

        // Kirim data + keyword ke view
        return view('sbs', compact('ds_digipos_sbs', 'search'));
    }
}