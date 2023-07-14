@extends('masterdb')
@section('konten')
<div class="row">
                        
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Total Pengguna</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <h4 class="text-white">{{ $totalPengguna }} Pengguna</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Transaksi Berhasil</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <h4>{{$transaksiBerhasil}} Transaksi</h4>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Total Produk</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <h4>{{$totalProduk}} Produk</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
@endsection