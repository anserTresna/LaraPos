<!-- cart.blade.php -->
@extends('masterdb')

@section('konten')
<form action="{{ route('cart.saveTransaction') }}" method="POST">
    @csrf
<div class="col-md-12">
    <div class="card m-0 shadow bg-light">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 pr-0 col-sm-12">
                    <div class="card me-0">
                        <div class="card-header bg-primary text-white">
                            <div class="card-title p-0 m-0">
                                <i class="fa fa-file me-2"></i> Invoice
                            </div>
                        </div>
                        <div class="card-body px-2 py-1">
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <tr>
                                        <td>No Invoice</td>
                                        <td><strong id="strong_no_invoice"></strong>
                                            <input type="hidden" name="no_invoice" value="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td id="td_tanggal">
                                            <input type="hidden" name="tanggal" value="">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kasir</td>
                                        <td>{{ Auth::user()->name }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end of card invoice -->

                    <div class="card mt-3 mb-3">
                        <div class="card-header bg-primary text-white">
                            <div class="card-title p-0 m-0">
                                <i class="fa fa-users me-2"></i>Customer
                            </div>
                        </div>
                        <div class="card-body px-2 py-1">
                            <div class="table-responsive">
                                <table class="table table-sm mb-1">
                                    <tr class="mt-1">
                                        <td>Jenis Customer</td>
                                        <td>
                                            <select class="form-control" name="customer" id="customer">
                                                <option value="0">Umum</option>
                                                <option value="1">Khusus</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end of card custome -->
                </div>
                <!-- end of col-md-3 pr-0 col-sm-12 -->

                <div class="col-md-9">
                    <div class="alert bg-primary p-2 pr-3" role="alert">
                        <h2 class="m-0 p-0 text-right text-dark fw-bolder" id="grandTotal">
                            GRAND TOTAL
                            :
                            Rp. 0,-</h2>
                        <input type="hidden" name="grandtotal">
                    </div>
                    <!-- end of alert -->
                    <div class="table-responsive">
                        <table id="tblTransaksi" class="table table-sm table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="25px">No.</th>
                                    <th width="100px">Nama Barang</th>

                                    <th>Harga</th>
                                    <th width="100x">Qty</th>
                                    <th>Subtotal</th>
                                    <th width="60px">Aksi</th>
                                </tr>
                                <tr>
                                    <td>
                                        <p id="no_head">#</p>
                                    </td>
                                    <td>
                                        <select class="js-example-basic-single form-control" id="input_kode" name="produk_id[]">
                                            @foreach ($produk as $product)
                                            <option value="{{ $product->id }}" data-harga="{{ $product->harga }}">{{
                                                $product->nama }}</option>
                                            @endforeach
                                        </select>
                                        {{-- <input type="hidden" name="produk_id" id="produk_id"> --}}

                                        <input type="hidden" class="form-control" id="nama_barang_hide" value="">
                                        <input type="hidden" class="form-control" placeholder="Stok" id="stok_head"
                                            disabled>
                                    </td>

                                    <td width="153px">
                                        <input type="hidden" id="harga_head">
                                        <input type="text" class="form-control" placeholder="Rp(harga)"
                                            id="harga_head_tampil" disabled style="cursor: not-allowed;">
                                    </td>

                                    <td width="83px">
                                        <input type="number" class="hanya-angka form-control" id="qty_head"
                                            placeholder="Qty" value="" min="1" tabindex="2">
                                    </td>
                                    <td>
                                        <input type="hidden" value="" id="subtotal_head">
                                        <input type="text" class="form-control" placeholder="Rp(subtotal)" value=""
                                            id="subtotal_head_tampil" disabled style="cursor: not-allowed;">
                                    </td>
                                    <td width="60px">
                                        <button class="btn btn-primary" id="btnAdd" type="button" tabindex="3" disabled>
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            </thead>
                            <tbody id="tbodyTransaksi">
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <textarea id="catatan" class="form-control form-control-sm font-italic mt-1 mb-3"
                                placeholder="Catatan (jika ada)" name="catatan" rows="4"
                                style="font-size: 16px"></textarea>
                        </div>

                        <div class="col-md-2"></div>

                        <div class="col-md-5">
                            
                            <table class="mt-1">
                                <tr>
                                    <td>
                                        <p class="fw-bolder text-right me-3">Bayar</p>
                                    </td>
                                    <td colspan="2">
                                        <div class="input-group input-group-lg mb-2 text-dark inputBayarDiv">
                                            <span class="input-group-text fw-bolder">Rp.</span>
                                            <input type="number" id="inputBayar" class="form-control fw-bolder" min="1" name="inputBayar">
                                            {{-- <input type="text" id="inputBayar" class="form-control fw-bolder" min="1"> --}}
                                            <input type="hidden" name="bayar">
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <p class="fw-bolder text-right me-3">Kembali</p>
                                    </td>
                                    <td colspan="2">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text fw-bolder">Rp.</span>
                                            <input type="text" id="kembalian" class="form-control fw-bolder"
                                                aria-label="Sizing example input"
                                                aria-describedby="inputGroup-sizing-lg" disabled
                                                style="cursor: not-allowed;">
                                            <input type="hidden" id="kembalianHidden" name="kembalian">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        
                        <div class="col-md-4 text-right mt-3">
                            <button class="btn btn-danger btn-sm" id="btnBatal">
                                <i class="fa fa-trash me-2"></i>Batal
                            </button>
                            
                            <button class="btn btn-primary btn-sm" id="btnSimpan" type="submit">
                                <i class="fa fa-save me-2"></i>Simpan
                            </button>
                            </form>

                            <button class="btn btn-success btn-sm" id="btnCetak" disabled style="cursor: not-allowed;">
                                <i class="fa fa-print me-2"></i>Cetak
                            </button>
                        </div>
                    </div>
                    <!-- end of row -->

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <!-- Tampilkan pesan success jika ada -->
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                </div>
                <!-- end of col-md-9 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of card-body(utama) -->
    </div>
    <!-- end of card m-0 -->
</div>
{{-- <script>
    $("#btnSimpan").on("click", function() {
        var items = [];
        $("#tbodyTransaksi tr").each(function() {
            var id = $(this).find(".produk_id").val();
            var quantity = $(this).find(".quantity").val();
            items.push([id, quantity]);
        });

        var catatan = $("#catatan").val();
        var bayar = $("#inputBayar").val();
        var no_invoice = $("#strong_no_invoice").text();
        var kasir_id = {{ Auth::user()->id }};

        var transactionData = {
            items: items,
            catatan: catatan,
            bayar: bayar,
            no_invoice: no_invoice,
            kasir_id: kasir_id
        };

        $.ajax({
            url: "{{ route('cart.saveTransaction') }}",
            method: "POST",
            data: transactionData,
            success: function(response) {
                alert("Transaksi berhasil disimpan!");
            },
            error: function(xhr, status, error) {
                alert("Gagal menyimpan transaksi. Silakan coba lagi.");
            }
        });
    });
</script> --}}
<script>
    $('#input_kode').on('select2:select', function (e) {
    var data = e.params.data;
    console.log(data);
    });
</script>

@endsection