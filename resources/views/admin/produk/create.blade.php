@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tambah Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.produk.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Produk</a></div>
                <div class="breadcrumb-item">Tambah Produk</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Produk</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategori as $kat)
                                            <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Harga Beli</label>
                                    <input type="number" name="harga_beli" class="form-control">
                                    @error('harga_beli')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="number" name="stok" class="form-control">
                                    @error('stok')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input type="text" name="nama" class="form-control">
                                    @error('nama')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Harga Jual</label>
                                    <input type="number" name="harga_jual" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Gambar Produk</label>
                                    <input type="file" name="gambar" class="form-control">
                                    @error('gambar')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
