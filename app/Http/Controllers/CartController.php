<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('query');
        $produk = Produk::select('id', 'nama', 'harga', 'jumlah')->get();
        return view('cart.index', compact('produk'));
    }
    public function saveTransaction(Request $request)
    {
        $request->validate([
            'inputBayar' => 'required|numeric|min:1',
            'produk_id' => 'required|array',
            'produk_id.*' => 'exists:produk,id',
        ], [
            'produk_id.required' => 'Tidak ada item yang dipilih.',
            'produk_id.array' => 'Format data item tidak valid.',
            'produk_id.*.exists' => 'Produk yang dipilih tidak valid.',
        ]);

        $produk_ids = $request->input('produk_id');
        $catatan = $request->input('catatan');
        $bayar = $request->input('inputBayar');
        $no_invoice = $request->input('no_invoice');
        $kasir_id = Auth::user()->id;

        // Simpan data transaksi ke dalam tabel Transaction
        $transaction = new Transaction();
        $transaction->no_invoice = $no_invoice;
        $transaction->tanggal = now();
        $transaction->catatan = $catatan;
        $transaction->bayar = $bayar;
        $transaction->kasir_id = $kasir_id;
        $transaction->save();

        foreach ($produk_ids as $produk_id) {
            $jumlah = $request->input('jumlah_' . $produk_id);

            $produk = Produk::find($produk_id);

            // Simpan detail transaksi ke dalam tabel TransactionDetail
            $transactionDetail = new TransactionDetail();
            $transactionDetail->transaction_id = $transaction->id;
            $transactionDetail->produk_id = $produk_id;
            $transactionDetail->jumlah = $jumlah;
            $transactionDetail->subtotal = $produk->harga * $jumlah;
            $transactionDetail->save();

            // Kurangi stok produk
            $produk->jumlah -= $jumlah;
            $produk->save();
        }

        return redirect()->back()->with('success', 'Transaksi berhasil disimpan.');
    }
}

