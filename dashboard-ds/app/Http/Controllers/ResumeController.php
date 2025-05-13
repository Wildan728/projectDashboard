<?php

namespace App\Http\Controllers;

use App\Models\SbsDs;
use App\Models\TrxDs;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function index()
    {
        // Ambil data dari tabel trx dan sbs
        $trxData = TrxDs::all();
        // $sbsData = SbsDs::all();

        return view('dashboard', compact('trxData'));
    }
}