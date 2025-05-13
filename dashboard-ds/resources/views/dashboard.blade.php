@extends('layouts.master')

@section('content')
    <form method="GET" action="{{ route('dashboard') }}">
        <label for="regional">Pilih Regional:</label>
        <select id="regional" name="regional" onchange="this.form.submit()">
            <option value="SUMBAGSEL" {{ request('regional', 'SUMBAGSEL') == 'SUMBAGSEL' ? 'selected' : '' }}>SUMBAGSEL
            </option>
            <option value="SUMBAGTENG" {{ request('regional') == 'SUMBAGTENG' ? 'selected' : '' }}>SUMBAGTENG</option>
            <option value="SUMBAGUT" {{ request('regional') == 'SUMBAGUT' ? 'selected' : '' }}>SUMBAGUT</option>
        </select>
    </form>

    <div class="container py-4">

        {{-- Pie Chart Revenue per Regional (Tengah) --}}
        <div class="row g-4 mb-4 justify-content-center">
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0 text-center">Total Revenue per Regional</h5>
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center" style="height: 350px;">
                        <canvas id="regionalPieChart" style="max-width: 100%; height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Top 5 Branch ACH ({{ $selectedRegional }})</h5>
                    </div>
                    <div class="card-body" style="height: 320px;">
                        <canvas id="topAchBranchChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Top 5 Cluster ACH ({{ $selectedRegional }})</h5>
                    </div>
                    <div class="card-body" style="height: 320px;">
                        <canvas id="topAchClusterChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bar Chart Revenue per Tipe --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Revenue Distribution ({{ $selectedRegional }})</h5>
                    </div>
                    <div class="card-body" style="height: 300px;">
                        <canvas id="revenueTypeChart" style="height:250px"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">User Aktif Per Branch ({{ $selectedRegional }})</h5>
                        {{-- <h3 class="card-text">{{ number_format($userAktifRegional, 0, ',', '.') }}</h3> --}}
                    </div>
                    <div class="card-body" style="height: 300px;">
                        <canvas id="userAktifBranchChart" style="height:250px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Top 5 Branch & Cluster Revenue --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Top 5 Branch Revenue ({{ $selectedRegional }})</h5>
                    </div>
                    <div class="card-body" style="height: 300px;">
                        <canvas id="topBranchesChart" style="height:250px"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Top 5 Cluster Revenue ({{ $selectedRegional }})</h5>
                    </div>
                    <div class="card-body" style="height: 300px;">
                        <canvas id="topClustersChart" style="height:250px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Rekap Data Territory --}}
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Rekap Data Territory</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0">
                        <thead class="table-danger text-center align-middle">
                            <tr>
                                <th rowspan="2" style="vertical-align: middle;">TERRITORY</th>
                                <th colspan="4">DIGIIPOS DS</th>
                                <th rowspan="2" style="vertical-align: middle;">RANKING<br>(DS TRX)</th>
                                <th colspan="8">REVENUE</th>
                                <th rowspan="2" style="vertical-align: middle;">TOTAL</th>
                            </tr>
                            <tr>
                                <th>ALL</th>
                                <th>TRX</th>
                                <th>ACH TRX</th>
                                <th>NO TRX</th>
                                <th>DATA</th>
                                <th>DIGITAL</th>
                                <th>EXTENSION</th>
                                <th>PPOB</th>
                                <th>RECHARGE</th>
                                <th>ROAMING</th>
                                <th>SELLOUT</th>
                                <th>VOICE SMS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $prevType = null; @endphp
                            @foreach ($territories as $territory)
                                @if ($prevType !== $territory['type'])
                                    <tr class="table-secondary fw-bold text-uppercase">
                                        <td colspan="16">{{ $territory['type'] }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    @if ($territory['type'] == 'regional')
                                        <td class="fw-bold text-danger">{{ $territory['name'] }}</td>
                                    @elseif($territory['type'] == 'branch')
                                        <td>{{ $territory['name'] }}</td>
                                    @elseif($territory['type'] == 'cluster')
                                        <td class="ps-4 fst-italic text-muted">{{ $territory['name'] }}</td>
                                    @endif

                                    <td class="text-center">{{ $territory['all'] ?? '-' }}</td>
                                    <td class="text-center">{{ $territory['trx'] ?? '-' }}</td>
                                    <td class="text-center">
                                        {{ isset($territory['ach']) ? number_format($territory['ach'], 2) . '%' : '-' }}
                                    </td>
                                    <td class="text-center">{{ $territory['no_trx'] ?? '-' }}</td>

                                    @php
                                        $rankCluster = $territory['rank']['cluster'] ?? null;
                                        $rankBranch = $territory['rank']['branch'] ?? null;
                                        $rankRegional = $territory['rank']['regional'] ?? null;
                                    @endphp
                                    <td class="text-center">
                                        @if ($territory['type'] == 'cluster')
                                            {{ $rankCluster ?? 'N/A' }}
                                        @elseif ($territory['type'] == 'branch')
                                            {{ $rankBranch ?? 'N/A' }}
                                        @elseif ($territory['type'] == 'regional')
                                            {{ $rankRegional ?? 'N/A' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    @foreach (['data', 'digital', 'extension', 'ppob', 'recharge', 'roaming', 'sellout', 'voice_sms', 'total'] as $col)
                                        <td class="text-center">
                                            {{ isset($territory[$col]) ? number_format($territory[$col], 0, '.', ',') : '-' }}
                                        </td>
                                    @endforeach
                                </tr>
                                @php $prevType = $territory['type']; @endphp
                            @endforeach
                            <script>
                                window.chartData = {!! json_encode($chartData) !!};
                                window.userAktifBranch = {!! json_encode($userAktifBranch ?? []) !!};
                                window.topBranches = {!! json_encode($topBranches ?? []) !!};
                                window.topClusters = {!! json_encode($topClusters ?? []) !!};
                                window.topAchBranches = {!! json_encode($topAchBranches ?? []) !!};
                                window.topAchClusters = {!! json_encode($topAchClusters ?? []) !!};
                            </script>
                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script src="{{ asset('js/grafik.js') }}"></script>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Load Chart.js -->
@endsection
