@extends('layouts.admin.admin-layout')

@section('title')
    Dana Desa
@endsection

@section('content')
    <div class="container-fluid pt-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><a href="/datadana"><i class="fa fa-place-of-worship me-2"></i>Dana Desa</a>
                </li>
            </ol>
        </nav>
        <div class="row vh-80 bg-light rounded mx-0">
            <div id="index" class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="card">
                        <div class="card-header">{{ __('Dana Desa') }}</div>
                        <div class="card-body">

                            <a href="/datadana/create" class="btn btn-outline-info btn-sm float-end mb-2"><i
                                    class="fas fa-plus-circle"></i>
                                Tambah Data Dana Desa
                            </a>

                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <table class="table" id="data_dana">
                                <thead>
                                    <tr>
                                        <th>No. </th>
                                        <th>Bidang</th>
                                        <th>Jumlah Pengeluaran (Rp.)</th>
                                        <th>Action </th>
                                    </tr>
                                </thead>
                                <tbody>
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
            $('#data_dana').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthChange: false,
                autoWidth: false,



                // Route untuk menampilkan data space
                ajax: '{{ route('data-DanaDesa') }}',

                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,

                    },

                    {
                        data: 'bidang',

                    },
                    {
                        data: 'jumlah',
                        render: function(data) {
                            return 'Rp. ' + data
                        }

                    },

                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
        });
    </script>
@endpush
