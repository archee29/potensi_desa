@extends('layouts.admin.admin-layout')

@section('title')
    Profile
@endsection

@section('content')
    <div class="container-fluid pt-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><a href="/profile"><i class="fa fa-users me-2"></i>Profile</a></li>
            </ol>
        </nav>
        <div class="row vh-80 bg-light rounded mx-0">
            <div id="index" class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <a href="/profile/create">
                        <button type="button" class="btn btn-outline-success"><i class="fas fa-plus-circle"></i>
                            Tambah
                            Data Artikel</button>
                    </a>
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Author</th>
                                <th scope="col">Judul Artikel</th>
                                <th scope="col">Isi Artikel</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>John</td>
                                <td>Doe</td>
                                <td>jhon@email.com</td>
                                <td>
                                    <a href="/profile/show">
                                        <button type="button" class="btn btn-outline-primary"><i class="fas fa-eye"></i>
                                            Detail</button>
                                    </a>
                                    <a href="/profile/edit">
                                        <button type="button" class="btn btn-outline-dark"><i
                                                class="fas fa-pencil-alt"></i>
                                            Edit
                                            Data</button>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i>
                                        Delete
                                        Data</button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
