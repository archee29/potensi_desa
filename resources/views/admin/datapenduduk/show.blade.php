@extends('layouts.admin.admin-layout')

@section('title')
    Detail Data
@endsection

@section('content')
    <div class="container-fluid pt-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><i class="fa fa-newspaper me-2"></i>Penduduk Desa</li>
                <li class="breadcrumb-item"><a href=""><i class="fas fa-eye me-2"></i>Detail Penduduk Desa</a>
                </li>
            </ol>
        </nav>
        <div class="row vh-80 bg-light rounded mx-0">
            <div id="edit" class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="card">
                        <div class="card-header">Detail Data Penduduk Desa</div>
                        <div class="card-body">
                            <form action="{{ route('datapenduduk.update', $datapenduduk) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-floating mb-3">
                                    <input type="text" name="dusun"
                                        class="form-control @error('dusun') is-invalid @enderror" id="floatingInput"
                                        placeholder="Nama Desa" readonly value="{{ $datapenduduk->dusun }}">
                                    <label for="floatingInput">Dusun</label>
                                    @error('dusun')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" name="cowok"
                                        class="form-control @error('cowok') is-invalid @enderror" id="floatingInput"
                                        placeholder="Nama Desa" readonly value="{{ $datapenduduk->cowok }}">
                                    <label for="floatingInput">Dusun</label>
                                    @error('cowok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" name="jumlah"
                                        class="form-control @error('jumlah') is-invalid @enderror" id="floatingInput"
                                        placeholder="Nama Desa" readonly value="{{ $datapenduduk->jumlah }}">
                                    <label for="floatingInput">Dusun</label>
                                    @error('jumlah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" name="luas"
                                        class="form-control @error('luas') is-invalid @enderror" id="floatingInput"
                                        placeholder="Nama Desa" readonly value="{{ $datapenduduk->luas }}">
                                    <label for="floatingInput">Dusun</label>
                                    @error('luas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="md:w-2/3 mb-3">
                                    <label for="formFile" class="form-label mt-3">Masukkan Tanggal Edit</label>
                                    <input
                                        class=" form-control bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                        id="inline-full-name" name="created_at" type="datetime-local" readonly
                                        value="{{ $datapenduduk->created_at }}">
                                </div>

                                <div class="form-group mt-3">
                                    <a href="/datapenduduk">
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
