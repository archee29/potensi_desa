@extends('layouts.admin.admin-layout')

@section('title')
    Pasar
@endsection

@section('add_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid pt-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><a href="/pasar"><i class="fa fa-store-alt me-2"></i>Pasar</a></li>
            </ol>
        </nav>
        <div class="row vh-80 bg-light rounded mx-0">
            <div id="index" class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="card">
                        <div class="card-header">{{ __('Pasar') }}</div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <a href="{{ route('pasar.create') }}" class="btn btn-outline-info btn-sm float-end mb-2"><i
                                    class="fas fa-plus-circle"></i>
                                Tambah Data Pasar
                            </a>

                            <table class="table table-responsive-lg  mt-4" id="data_pasar">
                                <thead>
                                    <tr>
                                        <th>No. </th>
                                        <th>Author </th>
                                        <th>Nama Dusun </th>
                                        <th>Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <th scope="row">1</th>
                                        <td>John</td>
                                        <td>Doe</td>
                                        <td>jhon@email.com</td>
                                        <td>
                                            <a href="/pasar/show">
                                                <button type="button" class="btn btn-outline-primary"><i
                                                        class="fas fa-eye"></i>
                                                    Detail</button>
                                            </a>
                                            <a href="/pasar/edit">
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
            $('#data_pasar').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthChange: false,
                autoWidth: false,

                // Route untuk menampilkan data space
                ajax: "{{ route('data-pasar') }}",
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
