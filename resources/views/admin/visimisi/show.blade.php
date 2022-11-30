@extends('layouts.admin.admin-layout')

@section('title')
    Detail Data
@endsection

@section('content')
    <div class="container-fluid pt-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><i class="fa fa-newspaper me-2"></i>Visi - Misi</li>
                <li class="breadcrumb-item"><a href=""><i class="fas fa-eye me-2"></i>Detail Visi - Misi</a>
                </li>
            </ol>
        </nav>
        <div class="row vh-80 bg-light rounded mx-0">
            <div id="edit" class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="card">
                        <div class="card-header">Edit Data Visi - Misi</div>
                        <div class="card-body">
                            <form action="{{ route('visimisi.update', $visimisi) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-floating mb-3">
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" id="floatingInput"
                                        placeholder="Nama Desa" readonly value="{{ $visimisi->name }}">
                                    <label for="floatingInput">Nama</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" name="jabatan" readonly
                                        class="form-control @error('Jabatan') is-invalid @enderror" id="floatingInput"
                                        placeholder="Nama Desa" value="{{ $visimisi->jabatan }}">
                                    <label for="floatingInput">Jabatan</label>
                                    @error('Jabatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea name="visi" readonly class="form-control @error('visi') is-invalid @enderror" id="floatingInput"
                                        style="height: 100px" placeholder="Nama Desa">{{ $visimisi->visi }}</textarea>
                                    <label for="floatingInput">Visi</label>
                                    @error('visi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea name="misi" readonly class="form-control @error('misi') is-invalid @enderror" id="floatingInput"
                                        style="height: 100px" placeholder="Nama Desa">{{ $visimisi->misi }}</textarea>
                                    <label for="floatingInput">Misi</label>
                                    @error('misi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="mb-3">
                                    <label for="formFile" class="form-label mt-3">Poto Gambar</label><br>
                                    <img id="previewImage" class="mb-3 mt-2  " src="{{ $visimisi->getImage() }}"
                                        width="20%">

                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="md:w-2/3 mb-3">
                                    <label for="formFile" class="form-label mt-3">Masukkan Tanggal Edit</label>
                                    <input
                                        class=" form-control bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                        id="inline-full-name" name="created_at" type="datetime-local" readonly
                                        value="{{ $visimisi->created_at }}">
                                </div>

                                <div class="form-group mt-3">
                                    <a href="/visimisi">
                                        <button type="button" class="btn btn-outline-danger m-2">Kembali</button>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
