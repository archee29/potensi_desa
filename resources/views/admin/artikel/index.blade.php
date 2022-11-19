@extends('layouts.admin.admin-layout')

@section('title')
    Artikel
@endsection

@section('content')
    <div class="container-fluid pt-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><a href=""><i class="fa fa-newspaper me-2"></i>Artikel</a></li>
            </ol>
        </nav>

        <div class="row vh-80 bg-light rounded mx-0">
            <div id="index" class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <a href="{{ route('artikel.create') }}">
                        <button type="button" class="btn btn-outline-success"><i class="fas fa-plus-circle"></i>
                            Tambah
                            Data Artikel</button>
                    </a>
                    <table class="table table-bordered mt-4">
                        <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Author</th>
                                <th scope="col">Date</th>
                                <th scope="col">Tittle</th>
                                <th scope="col">Content</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        @forelse ($artikel as $artikel)
                        <tbody>
                            <tr>
                                <td><img class="w-30 md:w-25 lg:w-30" src="/image/{{ $artikel->image }}" alt="" width="200px" height="100px"></td>
                                <td>{{ $artikel->author }}</td>
                                <td> {{ date('d-m-Y', strtotime($artikel->created_at))}}</td>
                                <td>{{ $artikel->title }}</td>
                                <td>{{ Str::limit($artikel->content, 50) }}</td>
                                <td>
                                    <a href="{{ route('artikel.show',$artikel->id)}}">
                                        <button type="button" class="btn btn-outline-primary"><i class="fas fa-eye"></i>
                                            Detail</button>
                                    </a>
                                    <a href="{{ route('artikel.edit',$artikel->id)}}">
                                        <button type="button" class="btn btn-outline-dark"><i
                                                class="fas fa-pencil-alt"></i>
                                            Edit
                                            Data</button>
                                    </a>
                                    <a href="{{ route('artikel.destroy',$artikel->id)}}">
                                        <button type="button" class="btn btn-outline-danger" ><i class="fas fa-trash-alt"></i>
                                        Delete
                                        Data</button></a>
                                </td>
                            </tr>
                        </tbody>
                        @empty
                        <p align="center">Halaman Masih Kosong</p>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
