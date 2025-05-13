@extends('layouts.master')

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">DS DIGIPOS SBU</h1>
    </div>
    <div>
        <form method="GET" action="{{ url('/sbu') }}" class="row mb-4">
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
                    <th>id_digipos</th>
                    <th>no_rs</th>
                    <th>nama-ds</th>
                    <th>tap</th>
                    <th>kecamatan</th>
                    <th>kabupaten</th>
                    <th>cluster</th>
                    <th>regional</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ds_digipos_sbu as $data)
                    <tr>
                        <td>{{ $data->id_digipos }}</td>
                        <td>{{ $data->no_rs }}</td>
                        <td>{{ $data->nama_ds }}</td>
                        <td>{{ $data->tap }}</td>
                        <td>{{ $data->kecamatan }}</td>
                        <td>{{ $data->kabupaten }}</td>
                        <td>{{ $data->cluster }}</td>
                        <td>{{ $data->regional }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $ds_digipos_sbu->links() }}
        </div>
    </div>
@endsection
