@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{ url('kategori-items') }}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
            </div>
            <div class="card">
                <div class="card-header">Detail Kategori Item</div>

                <div class="card-body">
                    <table class="mb-3">
                        <tr>
                            <th>Kode</th>
                            <td>:</td>
                            <td>{{ $data->kode }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{ $data->nama }}</td>
                        </tr>
                    </table>

                    <a class="btn btn-info" href="{{ url('kategori-items/form/edit') }}/{{ $data->id }}">Edit</a>
                    <a class="btn btn-danger" href="{{ url('kategori-items/delete') }}/{{ $data->id }}"
                        onclick="return confirm('Are you sure you want to delete this kategori?');">Delete</a>
                    <a class="btn btn-success" href="{{ url('kategori-items/pdf') }}/{{ $data->kode }}">Download PDF</a>

                    <hr>
                    <h5>List Master Items dengan Kategori Ini:</h5>
                    <table class="table table-bordered table-striped mt-2">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Item</th>
                                <th>Jenis</th>
                                <th>Supplier</th>
                                <th>Harga Beli</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data->masterItems as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->jenis }}</td>
                                <td>{{ $item->supplier }}</td>
                                <td>{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada item yang memiliki kategori ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
