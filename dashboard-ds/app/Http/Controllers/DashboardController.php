<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $bulan = 4;
        $tahun = 2025;
        $revColumns = ['data', 'digital', 'extension', 'ppob', 'recharge', 'roaming', 'sellout', 'voice_sms'];
        $allRegionals = ['SUMBAGSEL', 'SUMBAGTENG', 'SUMBAGUT'];

        $selectedRegional = $request->input('regional', 'SUMBAGSEL');

        // Ambil data trx untuk semua regional
        $trxData = DB::table('trx_ds')
            ->select('regional', 'branch', 'cluster_name')
            ->whereIn('regional', $allRegionals)
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->orderBy('regional')
            ->orderBy('branch')
            ->get();

        $territories = [];

        // 1. Tambahkan semua regional dulu
        foreach ($allRegionals as $regional) {
            $territories[] = ['type' => 'regional', 'name' => $regional];
        }

        // 2. Branch & cluster dari trx_ds sesuai regional terpilih
        $branches = $trxData->where('regional', $selectedRegional)
            ->pluck('branch')
            ->unique()
            ->filter()
            ->values();

        foreach ($branches as $branch) {
            $territories[] = ['type' => 'branch', 'name' => $branch];
        }

        $clusters = $trxData->where('regional', $selectedRegional)
            ->pluck('cluster_name')
            ->unique()
            ->filter()
            ->values();

        foreach ($clusters as $cluster) {
            $territories[] = ['type' => 'cluster', 'name' => $cluster];
        }

        // 3. Hitung cluster_count dari tabel cluster sesuai regional
        $clusterTable = [
            'SUMBAGSEL' => 'ds_digipos_sbs',
            'SUMBAGTENG' => 'ds_digipos_sbt',
            'SUMBAGUT' => 'ds_digipos_sbu',
        ][$selectedRegional];

        $clusterCounts = DB::table($clusterTable)
            ->select('cluster', DB::raw('count(*) as cluster_count'))
            ->groupBy('cluster')
            ->pluck('cluster_count', 'cluster');

        $trxCounts = DB::table('trx_ds')
            ->selectRaw('cluster_name, COUNT(DISTINCT user_id) as user_count')
            ->where('regional', $selectedRegional)
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->groupBy('cluster_name')
            ->pluck('user_count', 'cluster_name');

        foreach ($territories as $key => $t) {
            if ($t['type'] === 'cluster') {
                $all = $clusterCounts[$t['name']] ?? 0;
                $trx = $trxCounts[$t['name']] ?? 0;
                $territories[$key] += [
                    'all' => $all,
                    'trx' => $trx,
                    'ach' => $all ? min(100, round(($trx / $all) * 100, 2)) : 0,
                    'no_trx' => max(0, $all - $trx),
                ];
            }
        }

        // 4. Revenue per cluster
        $clusterNames = collect($territories)->where('type', 'cluster')->pluck('name');
        $sumPricesByType = DB::table('trx_ds')
            ->select(
                'cluster_name',
                DB::raw("SUM(CASE WHEN trx_type = 'DATA' THEN price ELSE 0 END) as data"),
                DB::raw("SUM(CASE WHEN trx_type = 'DIGITAL' THEN price ELSE 0 END) as digital"),
                DB::raw("SUM(CASE WHEN trx_type = 'EXTENSION' THEN price ELSE 0 END) as extension"),
                DB::raw("SUM(CASE WHEN trx_type = 'PPOB' THEN price ELSE 0 END) as ppob"),
                DB::raw("SUM(CASE WHEN trx_type = 'RECHARGE' THEN price ELSE 0 END) as recharge"),
                DB::raw("SUM(CASE WHEN trx_type = 'ROAMING' THEN price ELSE 0 END) as roaming"),
                DB::raw("SUM(CASE WHEN trx_type = 'SELLOUT' THEN price ELSE 0 END) as sellout"),
                DB::raw("SUM(CASE WHEN trx_type = 'VOICE_SMS' THEN price ELSE 0 END) as voice_sms")
            )
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->whereIn('cluster_name', $clusterNames)
            ->groupBy('cluster_name')
            ->get()
            ->keyBy('cluster_name');

        foreach ($territories as $key => $t) {
            if ($t['type'] === 'cluster') {
                $sum = $sumPricesByType[$t['name']] ?? null;
                foreach ($revColumns as $col) {
                    $territories[$key][$col] = $sum->$col ?? 0;
                }
                $territories[$key]['total'] = array_sum(array_map(fn($c) => $territories[$key][$c], $revColumns));
            } else {
                foreach ($revColumns as $col) $territories[$key][$col] = null;
                $territories[$key]['total'] = 0;
            }
        }

        // 5. Perhitungan branch (akumulasi cluster di bawahnya)
        foreach ($territories as $key => $t) {
            if ($t['type'] === 'branch') {
                $branchName = $t['name'];
                $clustersInBranch = $trxData->where('regional', $selectedRegional)->where('branch', $branchName)->pluck('cluster_name')->filter();

                $territories[$key]['all'] = $territories[$key]['trx'] = $territories[$key]['total'] = 0;
                foreach ($revColumns as $col) $territories[$key][$col] = 0;

                foreach ($territories as $tt) {
                    if ($tt['type'] === 'cluster' && $clustersInBranch->contains($tt['name'])) {
                        $territories[$key]['all'] += $tt['all'] ?? 0;
                        $territories[$key]['trx'] += $tt['trx'] ?? 0;
                        foreach ($revColumns as $col) {
                            $territories[$key][$col] += $tt[$col] ?? 0;
                        }
                        $territories[$key]['total'] += $tt['total'] ?? 0;
                    }
                }
                $territories[$key]['ach'] = $territories[$key]['all']
                    ? round(($territories[$key]['trx'] / $territories[$key]['all']) * 100, 2)
                    : 0;
                $territories[$key]['no_trx'] = max(0, $territories[$key]['all'] - $territories[$key]['trx']);
            }
        }

        // 6. Perhitungan regional (all, trx, revenue, dll)
        foreach ($territories as $key => $t) {
            if ($t['type'] === 'regional') {
                switch ($t['name']) {
                    case 'SUMBAGUT':
                        $territories[$key]['all'] = DB::table('ds_digipos_sbu')->count();
                        break;
                    case 'SUMBAGTENG':
                        $territories[$key]['all'] = DB::table('ds_digipos_sbt')->count();
                        break;
                    case 'SUMBAGSEL':
                        $territories[$key]['all'] = DB::table('ds_digipos_sbs')->count();
                        break;
                }
            }
        }

        // 7. trx regional
        foreach ($territories as $key => $t) {
            if ($t['type'] === 'regional') {
                $territories[$key]['trx'] = DB::table('trx_ds')
                    ->where('regional', $t['name'])
                    ->whereMonth('created_at', $bulan)
                    ->whereYear('created_at', $tahun)
                    ->distinct('user_id')
                    ->count('user_id');
            }
        }

        // 8. no_trx regional
        foreach ($territories as $key => $territory) {
            if ($territory['type'] === 'regional') {
                $all = $territory['all'] ?? 0;
                $trx = $territory['trx'] ?? 0;
                $territories[$key]['no_trx'] = max(0, $all - $trx);
            }
        }

        // 9. ach regional
        foreach ($territories as $key => $territory) {
            if ($territory['type'] === 'regional') {
                $trx = $territory['trx'] ?? 0;
                $all = $territory['all'] ?? 0;
                $territories[$key]['ach'] = $all > 0 ? round(($trx / $all) * 100, 2) : 0;
            }
        }

        // 10. Revenue regional
        foreach ($territories as $key => $t) {
            if ($t['type'] === 'regional') {
                $regionalName = $t['name'];
                $sumRegional = DB::table('trx_ds')
                    ->select(
                        DB::raw("SUM(CASE WHEN trx_type = 'DATA' THEN price ELSE 0 END) as data"),
                        DB::raw("SUM(CASE WHEN trx_type = 'DIGITAL' THEN price ELSE 0 END) as digital"),
                        DB::raw("SUM(CASE WHEN trx_type = 'EXTENSION' THEN price ELSE 0 END) as extension"),
                        DB::raw("SUM(CASE WHEN trx_type = 'PPOB' THEN price ELSE 0 END) as ppob"),
                        DB::raw("SUM(CASE WHEN trx_type = 'RECHARGE' THEN price ELSE 0 END) as recharge"),
                        DB::raw("SUM(CASE WHEN trx_type = 'ROAMING' THEN price ELSE 0 END) as roaming"),
                        DB::raw("SUM(CASE WHEN trx_type = 'SELLOUT' THEN price ELSE 0 END) as sellout"),
                        DB::raw("SUM(CASE WHEN trx_type = 'VOICE_SMS' THEN price ELSE 0 END) as voice_sms")
                    )
                    ->where('regional', $regionalName)
                    ->whereMonth('created_at', $bulan)
                    ->whereYear('created_at', $tahun)
                    ->first();

                foreach ($revColumns as $col) {
                    $territories[$key][$col] = $sumRegional->$col ?? 0;
                }
                $territories[$key]['total'] = array_sum(array_map(fn($c) => $territories[$key][$c], $revColumns));
            }
        }

        // 11. Ranking
        foreach (['cluster', 'branch', 'regional'] as $type) {
            $achValues = collect($territories)
                ->where('type', $type)
                ->mapWithKeys(fn($t, $k) => [$k => $t['ach']])
                ->sortDesc();

            $rank = 0;
            $prevAch = null;

            foreach ($achValues as $key => $ach) {
                if ($ach !== $prevAch) $rank++;
                $territories[$key]['rank'][$type] = $rank;
                $prevAch = $ach;
            }
        }

        // 12. Data grafik (opsional)
        $chartData = [
            'regional' => [
                'labels' => [],
                'total' => [],
                'colors' => ['#FF6384', '#36A2EB', '#FFCE56']
            ],
            'revenue_types' => [
                'labels' => ['DATA', 'DIGITAL', 'EXTENSION', 'PPOB', 'RECHARGE', 'ROAMING', 'SELLOUT', 'VOICE_SMS'],
                'data' => array_fill(0, 8, 0),
                'colors' => ['#4BC0C0', '#FF9F40', '#9966FF', '#FFCD56', '#C9CBCF', '#EB6841', '#00A8C6', '#D95B43']
            ]
        ];

        foreach ($territories as $t) {
            if ($t['type'] === 'regional') {
                $chartData['regional']['labels'][] = $t['name'];
                $chartData['regional']['total'][] = $t['total'];
            }
        }
        foreach ($territories as $t) {
            if ($t['type'] === 'regional' && $t['name'] === $selectedRegional) {
                foreach ($chartData['revenue_types']['labels'] as $key => $type) {
                    $col = strtolower($type);
                    $chartData['revenue_types']['data'][$key] = $t[$col] ?? 0;
                }
            }
        }

        // Query: User aktif (user unik yang transaksi) per branch di regional terpilih (April 2025)
        $userAktifBranch = DB::table('trx_ds')
            ->select('branch', DB::raw('COUNT(DISTINCT user_id) as user_aktif'))
            ->where('regional', $selectedRegional)
            ->whereMonth('created_at', 4)
            ->whereYear('created_at', 2025)
            ->whereNotNull('branch')
            ->groupBy('branch')
            ->orderBy('branch')
            ->get();




        // Top 5 branch revenue tertinggi
        // Branch mana yang paling berkontribusi di regional terpilih.
        $topBranches = DB::table('trx_ds')
            ->select('branch', DB::raw('SUM(price) as total_revenue'))
            ->where('regional', $selectedRegional)
            ->whereMonth('created_at', 4)
            ->whereYear('created_at', 2025)
            ->whereNotNull('branch')
            ->groupBy('branch')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        // Top 5 cluster revenue tertinggi
        // Cluster mana yang paling berkontribusi di regional terpilih.
        $topClusters = DB::table('trx_ds')
            ->select('cluster_name', DB::raw('SUM(price) as total_revenue'))
            ->where('regional', $selectedRegional)
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->whereNotNull('cluster_name')
            ->groupBy('cluster_name')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        $topAchBranches = collect($territories)
            ->where('type', 'branch')
            ->sortByDesc('ach')
            ->take(5)
            ->values();

        $topAchClusters = collect($territories)
            ->where('type', 'cluster')
            ->sortByDesc('ach')
            ->take(5)
            ->values();


        return view('dashboard', compact('territories', 'chartData', 'selectedRegional', 'topClusters', 'topBranches', 'topAchBranches', 'topAchClusters', 'userAktifBranch'));
    }
}