<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ProdukControllers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $produk = Produk::where('user_id', $user->id)->paginate(10);
        return view('produk.index', compact('produk'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    $validatedData = $request->validate([
        'nama' => 'required|min:3|max:255',
        'harga' => 'required|numeric',
        'jumlah' => 'required|integer',
        // 'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Upload gambar
    // $tanggal = now()->format('Ymd');
    // $namaFile = 'PRD-' . $tanggal . '-' . uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
    // $gambarPath = $request->file('gambar')->move(public_path('produk/'.$tanggal), $namaFile);
    // $gambarUrl = 'produk/' . $tanggal . '/' . $namaFile;

    $user = auth()->user();
    $produk = new Produk();
    $produk->nama = $validatedData['nama'];
    $produk->harga = $validatedData['harga'];
    $produk->jumlah = $validatedData['jumlah'];
    // $produk->gambar = $gambarUrl;
    $produk->user_id = $user->id; // Assign user_id
    $produk->save();

    return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('kelolaproduk.edit', compact('produk'));
    }    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
        'nama' => 'required',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'harga' => 'required',
        'jumlah' => 'required',
    ]);

    // Menyimpan data produk
    $produk = Produk::findOrFail($id);
    $produk->nama = $validatedData['nama'];
    $produk->harga = $validatedData['harga'];
    $produk->jumlah = $validatedData['jumlah'];

    if ($request->hasFile('gambar')) {
        // Upload gambar baru
        $tanggal = now()->format('Ymd');
        $namaFile = 'PRD-' . $tanggal . '-' . uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
        $gambarPath = $request->file('gambar')->move(public_path('produk/'.$tanggal), $namaFile);
        $gambarUrl = 'produk/' . $tanggal . '/' . $namaFile;
        $produk->gambar = $gambarUrl;

        // Hapus gambar lama (jika ada)
        Storage::delete($produk->gambar);
    }

    $produk->save();

    return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    $produk = Produk::findOrFail($id);

    // Hapus gambar terkait (jika ada)
    Storage::delete($produk->gambar);

    $produk->delete();

    return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
}
    }

