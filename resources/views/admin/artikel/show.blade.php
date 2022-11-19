@extends('layouts.admin.admin-layout')

@section('title')
    Detail
@endsection

@section('content')
    <div class="container-fluid pt-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><i class="fa fa-newspaper me-2"></i>Artikel</li>
                <li class="breadcrumb-item"><a href=""><i class="fas fa-eye me-2"></i>Detail Artikel</a></li>
            </ol>
        </nav>
        <div class="row vh-80 bg-light rounded mx-0">
            <div id="show" class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">

                    <div class="form mb-3">
                        <input class="form-control" type="text" value="{{ $artikel->author }}" aria-label="readonly input example"
                            readonly>
                    </div>
                    <div class="form mb-3">
                        <input class="form-control" type="text" value="{{ $artikel->title }}" aria-label="readonly input example"
                            readonly>
                    </div>
                    <div class="form mb-3">
                        <textarea aria-label="readonly input example" class="form-control" placeholder="{{ $artikel->content }}" id="floatingTextarea"
                            style="height: 150px;" readonly></textarea>
                    </div>
                    <div class="form mb-3">
                        <img class="w-30 md:w-25 lg:w-30" src="/image/{{ $artikel->image }}" alt="" width="200px" height="200px">
                    </div>
                    <div class="form mb-3">
                        <input class="form-control" type="text" value="{{ $artikel->image }}"
                            aria-label="readonly input example" readonly>
                    </div>
                    <div class="form md:w-2/3 mb-3">
                        <label for="formFile" class="form-label mt-3">Tanggal Upload</label>
                        <input
                            class=" form-control bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            aria-label="readonnly input example" id="inline-full-name" name="" value="{{ date('d-m-Y', strtotime($artikel->created_at))}}" readonly>
                    </div>
                    <div class="m-n2">
                        <a href="/artikel">
                            <button type="button" class="btn btn-outline-primary m-2">Kembali</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
