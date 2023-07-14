<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        // Mengambil data pegawai yang terkait dengan user yang sedang login
        $pegawai = User::where('user_id', $user->id)->paginate(5);

        return view('pegawai.index', compact('pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Tampilkan form untuk membuat pegawai baru
        return view('pegawai.create');
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
            'name' => 'required|min:3|max:255',
            'email' => 'required|unique:users',
            'password' => 'required|min:8|max:255',
            'alamat' => 'required|min:3|max:255',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        // Mendapatkan user yang sedang login
        $user = auth()->user();

        // Membuat instance pegawai dengan data yang divalidasi
        $pegawai = new User($validatedData);
        $pegawai->user_id = $user->id;
        $pegawai->save();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pegawai = User::find($id);

        if (!$pegawai) {
            return response()->json(['message' => 'Pegawai not found'], 404);
        }

        return view('pegawai.edit', compact('pegawai'));
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
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:8|max:255',
            'role' => 'required',
        ]);

        $pegawai = User::find($id);

        if (!$pegawai) {
            return response()->json(['message' => 'Pegawai not found'], 404);
        }

        $pegawai->name = $validatedData['name'];
        $pegawai->email = $validatedData['email'];

        if (!empty($validatedData['password'])) {
            $pegawai->password = Hash::make($validatedData['password']);
        }

        $pegawai->role = $validatedData['role'];
        $pegawai->save();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pegawai = User::find($id);

        if (!$pegawai) {
            return response()->json(['message' => 'Pegawai not found'], 404);
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus');
    }
}
