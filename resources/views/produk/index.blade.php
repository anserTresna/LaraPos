@extends('masterdb')
@section('konten')
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Kelola <b>produk</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="#addProductModal" class="btn btn-success" data-toggle="modal"><i
                                class="material-icons">&#xE147;</i> <span>Tambah Data produk</span></a>
                        <a href="#deleteProductModal" class="btn btn-danger" data-toggle="modal"><i
                                class="material-icons">&#xE15C;</i> <span>Delete</span></a>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>
                            <span class="custom-checkbox">
                                <input type="checkbox" id="selectAll">
                                <label for="selectAll"></label>
                            </span>
                        </th>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Gambar</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produk as $item)
                    <tr>
                        <td>
                            <span class="custom-checkbox">
                                <input type="checkbox" id="checkbox1" name="options[]" value="1">
                                <label for="checkbox1"></label>
                            </span>
                        </td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->harga }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td><img src="{{ asset('public/produk' . $item->gambar) }}" alt="Gambar Produk" width="50"></td>
                        <td>
                            <a href="#editProductModal{{ $item->id }}" class="edit" data-toggle="modal"><i
                                    class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                            <a href="#deleteProductModal{{ $item->id }}" class="delete" data-toggle="modal"><i
                                    class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
            </table>
            <div class="clearfix">
                <div class="hint-text">Showing <b>{{ $produk->firstitem() }}</b> to <b>{{ $produk->lastitem() }}</b>
                    of <b>{{ $produk->total() }}</b> entries</div>
                <ul class="pagination">
                    @if ($produk->currentPage() > 1)
                    <li class="page-item"><a href="{{ $produk->previousPageUrl() }}" class="page-link">Previous</a></li>
                    @else
                    <li class="page-item disabled"><a href="#" class="page-link">Previous</a></li>
                    @endif

                    @for ($i = 1; $i <= $produk->lastPage(); $i++)
                        <li class="page-item {{ $i == $produk->currentPage() ? 'active' : '' }}"><a
                                href="{{ $produk->url($i) }}" class="page-link">{{ $i }}</a></li>
                        @endfor

                        @if ($produk->currentPage() < $produk->lastPage())
                            <li class="page-item"><a href="{{ $produk->nextPageUrl() }}" class="page-link">Next</a></li>
                            @else
                            <li class="page-item disabled"><a href="#" class="page-link">Next</a></li>
                            @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Add Modal HTML -->
<div id="addProductModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('produk.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Tambah produk</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" class="form-control" name="harga" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" required>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" class="form-control" name="gambar">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Batal">
                    <input type="submit" class="btn btn-success" value="Tambah">
                </div>
            </form>
        </div>
    </div>
</div>
@foreach($produk as $item)
<!-- Edit Modal HTML -->
<div id="editProductModal{{ $item->id }}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('produk.update', $item->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h4 class="modal-title">Edit Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" value="{{ $item->nama }}" required>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" class="form-control" name="harga" value="{{ $item->harga }}" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" value="{{ $item->jumlah }}" required>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" class="form-control" name="gambar">
                        <img src="{{ asset($item->gambar) }}" alt="Produk">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Batal">
                    <input type="submit" class="btn btn-info" value="Simpan">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Modal HTML -->
<div id="deleteProductModal{{ $item->id }}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('produk.destroy', $item->id) }}">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h4 class="modal-title">Hapus produk</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data?</p>
                    <p class="text-warning"><small>Aksi ini tidak dapat dibatalkan.</small></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Batal">
                    <input type="submit" class="btn btn-danger" value="Hapus">
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection