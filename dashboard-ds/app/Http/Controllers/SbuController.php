<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SbuController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input search dari form
        $search = $request->input('search');

        // Query ke tabel + search jika ada input
        $ds_digipos_sbu = DB::table('ds_digipos_sbu')
            ->when($search, function ($query, $search) {
                $query->where('id_digipos', 'like', "%{$search}%")
                    ->orWhere('no_rs', 'like', "%{$search}%")
                    ->orWhere('nama_ds', 'like', "%{$search}%")
                    ->orWhere('tap', 'like', "%{$search}%")
                    ->orWhere('kecamatan', 'like', "%{$search}%")
                    ->orWhere('kabupaten', 'like', "%{$search}%")
                    ->orWhere('cluster', 'like', "%{$search}%")
                    ->orWhere('regional', 'like', "%{$search}%");
            })
            ->paginate(10);

        // Agar tetap membawa keyword search saat pindah halaman
        $ds_digipos_sbu->appends(['search' => $search]);

        // Kirim data + keyword ke view
        return view('sbu', compact('ds_digipos_sbu', 'search'));
    }
}
