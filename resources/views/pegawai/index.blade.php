@extends('masterdb')
@section('konten')
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Kelola <b>Pegawai</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i
                                class="material-icons">&#xE147;</i> <span>Tambah Data Pegawai</span></a>
                        <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i
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
                        <th>Id User</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>alamat</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pegawai as $user)
                    <tr>
                        <td>
                            <span class="custom-checkbox">
                                <input type="checkbox" id="checkbox1" name="options[]" value="1">
                                <label for="checkbox1"></label>
                            </span>
                        </td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                
                        <td>{{ $user->alamat }}</td>
                        <td>
                            <a href="#editEmployeeModal{{ $user->id }}" class="edit" data-toggle="modal"><i
                                    class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                            <a href="#deleteEmployeeModal{{ $user->id }}" class="delete" data-toggle="modal"><i
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
                <div class="hint-text">Showing <b>{{ $pegawai->firstItem() }}</b> to <b>{{ $pegawai->lastItem() }}</b>
                    of <b>{{
                        $pegawai->total() }}</b> entries</div>
                <ul class="pagination">
                    @if ($pegawai->currentPage() > 1)
                    <li class="page-item"><a href="{{ $pegawai->previousPageUrl() }}" class="page-link">Previous</a>
                    </li>
                    @else
                    <li class="page-item disabled"><a href="#" class="page-link">Previous</a></li>
                    @endif

                    @for ($i = 1; $i <= $pegawai->lastPage(); $i++)
                        <li class="page-item {{ $i == $pegawai->currentPage() ? 'active' : '' }}"><a
                                href="{{ $pegawai->url($i) }}" class="page-link">{{ $i }}</a></li>
                        @endfor

                        @if ($pegawai->currentPage() < $pegawai->lastPage())
                            <li class="page-item"><a href="{{ $pegawai->nextPageUrl() }}" class="page-link">Next</a>
                            </li>
                            @else
                            <li class="page-item disabled"><a href="#" class="page-link">Next</a></li>
                            @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Add Modal HTML -->
<div id="addEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="/user">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Pegawai</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="alamat" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required></input>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-success" value="Add">
                </div>
            </form>
        </div>
    </div>
</div>
@foreach($pegawai as $user)
<!-- Edit Modal HTML -->
<div id="editEmployeeModal{{ $user->id }}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('pegawai.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h4 class="modal-title">Edit Employee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="email" class="form-control" name="email" value="{{ $user->alamat }}" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <textarea class="form-control" name="password" required>{{ $user->password }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-info" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Modal HTML -->
<div id="deleteEmployeeModal{{ $user->id }}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('pegawai.destroy', $user->id) }}">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Pegawai</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin menghapus data?</p>
                    <p class="text-warning"><small>Aksi ini tidak dapat dibatalkan.</small></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-danger" value="Delete">
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection