@extends('layouts.admin.admin-layout')

@section('title')
    Lokasi
@endsection

@section('add_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="container-fluid pt-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><a href="/lokasi"><i class="fa fa-map-marker-alt"></i> Lokasi</a></li>
            </ol>
        </nav>
        <div class="row  justify-content-center vh-80 bg-light rounded mx-0">
            <div id="index" class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="card">
                        <div class="card-header">{{ __('Lokasi') }}</div>
                        <div class="card-body">
                            <a href="{{ route('lokasi.create') }}" class="btn btn-outline-info btn-sm float-end mb-2"><i
                                    class="fas fa-plus-circle"></i>
                                Tambah Data Lokasi
                            </a>
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <table class="table table-responsive-lg table-bordered mt-4" id="dataLokasi">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Author</th>
                                        <th>Nama Desa</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <th scope="row">1</th>
                                        <td>John</td>
                                        <td>Doe</td>
                                        <td>jhon@email.com</td>
                                        <td>
                                            <a href="/lokasi/show">
                                                <button type="button" class="btn btn-outline-primary"><i
                                                        class="fas fa-eye"></i>
                                                    Detail</button>
                                            </a>
                                            <a href="/lokasi/edit">
                                                <button type="button" class="btn btn-outline-dark"><i
                                                        class="fas fa-pencil-alt"></i>
                                                    Edit
                                                    Data</button>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger"><i
                                                    class="fas fa-trash-alt"></i>
                                                Delete
                                                Data</button>
                                        </td>
                                    </tr> --}}
                                </tbody>
                            </table>
                            <form action="" method="POST" id="deleteForm">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Hapus" style="display: none">
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(function() {
            $('#dataLokasi').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthChange: false,
                autoWidth: false,

                // Route untuk menampilkan data space
                ajax: '{{ route('data-lokasi') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'action'
                    }
                ]
            })
        })
    </script>
@endpush
