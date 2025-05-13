@extends('layouts.master')

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">DS DIGIPOS SBS</h1>
    </div>
    <div>
        <form method="GET" action="{{ url('/sbs') }}" class="row mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Pencarian" value="{{ $search ?? '' }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
    </div>
    <div class="container mt-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Branch</th>
                    <th>Mitra Sbp</th>
                    <th>Cluster</th>
                    <th>City</th>
                    <th>Nama_direct_sales</th>
                    <th>user_id</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ds_digipos_sbs as $data)
                    <tr>
                        <td>{{ $data->branch }}</td>
                        <td>{{ $data->mitra_sbp }}</td>
                        <td>{{ $data->cluster }}</td>
                        <td>{{ $data->city }}</td>
                        <td>{{ $data->nama_direct_sales }}</td>
                        <td>{{ $data->user_id }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $ds_digipos_sbs->links() }}
        </div>
    </div>
@endsection
