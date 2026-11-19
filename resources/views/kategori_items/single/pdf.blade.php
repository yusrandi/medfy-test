<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Kategori - {{ $data->nama }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .header h2 {
            margin: 0;
        }

        .info-table {
            margin-bottom: 15px;
        }

        .info-table th {
            text-align: left;
            padding-right: 15px;
            padding-bottom: 4px;
        }

        table.items {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.items,
        table.items th,
        table.items td {
            border: 1px solid #333;
            word-wrap: break-word;
        }

        table.items th {
            background-color: #f2f2f2;
            padding: 6px;
            text-align: left;
        }

        table.items td {
            padding: 6px;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: right;
            font-size: 10px;
            color: #555;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Detail Kategori Items</h2>
    </div>

    <!-- 1 & 2. Nama Kategori dan Kode Kategori -->
    <table class="info-table">
        <tr>
            <th>Kode Kategori</th>
            <td>: {{ $data->kode }}</td>
        </tr>
        <tr>
            <th>Nama Kategori</th>
            <td>: {{ $data->nama }}</td>
        </tr>
    </table>

    <!-- 3. Informasi item yang memiliki kategori tersebut dalam bentuk tabel -->
    <h4>Daftar Master Items</h4>
    <table class="items">
        <thead>
            <tr>
                <th style="width: 7%;" class="text-center">No</th>
                <th style="width: 14%;">Kode</th>
                <th style="width: 24%;">Nama Item</th>
                <th style="width: 12%;">Jenis</th>
                <th style="width: 16%;">Supplier</th>
                <th style="width: 14%;">Harga Beli</th>
                <th style="width: 13%;">Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data->masterItems as $i => $item)
            @php
            $hargaJual = $item->harga_beli + ($item->harga_beli * $item->laba / 100);
            @endphp
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->jenis }}</td>
                <td>{{ $item->supplier }}</td>
                <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($hargaJual, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada item dalam kategori ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- 4. Informasi tanggal dan waktu dicetak pada footer PDF -->
    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>

</html>
