<?php

namespace App\Http\Controllers;

use App\Models\KategoriItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KategoriItemController extends Controller
{
    public function index()
    {
        return view('kategori_items.index.index');
    }
    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $data_search = KategoriItem::query();
        if (!empty($kode)) $data_search->where('kode', $kode);
        if (!empty($nama)) $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        $data_search = $data_search->select('kode', 'nama')->orderBy('id')->get();
        return response()->json([
            'status' => 200,
            'data'   => $data_search
        ]);
    }
    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = [];
        } else {
            $item = KategoriItem::findOrFail($id);
        }
        return view('kategori_items.form.index', [
            'item'   => $item,
            'method' => $method
        ]);
    }
    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new KategoriItem;
            $kode = $request->kode ?: 'KAT-' . str_pad(KategoriItem::withTrashed()->count('id') + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $data_item = KategoriItem::findOrFail($id);
            $kode = $request->kode ?: $data_item->kode;
        }
        $data_item->kode = $kode;
        $data_item->nama = $request->nama;
        $data_item->save();
        return redirect('kategori-items');
    }
    public function singleView($kode)
    {
        // Eager Loading masterItems sesuai Catatan #2 Soal
        $data = KategoriItem::with('masterItems')->where('kode', $kode)->firstOrFail();
        return view('kategori_items.single.index', compact('data'));
    }
    public function delete($id)
    {
        $kategori = KategoriItem::findOrFail($id);
        $kategori->masterItems()->detach(); // Lepas relasi di tabel pivot
        $kategori->delete();
        return redirect('kategori-items');
    }

    public function exportPdf($kode)
    {
        $data = KategoriItem::with('masterItems')->where('kode', $kode)->firstOrFail();
        $pdf = Pdf::loadView('kategori_items.single.pdf', compact('data'))
            ->setPaper('a4', 'portrait');
        return $pdf->download('kategori-' . $data->kode . '.pdf');
    }
}
