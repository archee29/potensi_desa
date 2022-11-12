@extends('layouts.admin.admin-layout')

@section('title')
    Rumah Ibadah
@endsection

@section('content')
    <div class="container-fluid pt-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><a href="/rumah-ibadah"><i class="fa fa-place-of-worship me-2"></i>Rumah Ibadah</a>
                </li>
            </ol>
        </nav>
        <div class="row vh-80 bg-light rounded mx-0">
            <div id="index" class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="card">
                        <div class="card-header">{{ __('Rumah Ibadah') }}</div>
                        <div class="card-body">
                            <a href="/rumah-ibadah/create" class="btn btn-outline-info btn-sm float-end mb-2"><i
                                    class="fas fa-plus-circle"></i>
                                Tambah Data Rumah Ibadah
                            </a>
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <table class="table table-responsive-lg table-bordered mt-4" id="dataLokasi">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Author</th>
                                        <th>Judul Artikel</th>
                                        <th>Isi Artikel</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>John</td>
                                        <td>Doe</td>
                                        <td>jhon@email.com</td>
                                        <td>
                                            <a href="/rumah-ibadah/show">
                                                <button type="button" class="btn btn-outline-primary"><i
                                                        class="fas fa-eye"></i>
                                                    Detail</button>
                                            </a>
                                            <a href="/rumah-ibadah/edit">
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
                                    </tr>
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
