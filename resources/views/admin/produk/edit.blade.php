@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.produk.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Produk</a></div>
                <div class="breadcrumb-item">Edit Produk</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit Produk</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategori as $kat)
                                            <option value="{{ $kat->id }}"
                                                {{ $kat->id == $produk->category_id ? 'selected' : '' }}>
                                                {{ $kat->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Harga Beli</label>
                                    <input type="number" name="harga_beli" class="form-control"
                                        value="{{ $produk->harga_beli }}">
                                    @error('harga_beli')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="number" name="stok" class="form-control" value="{{ $produk->stok }}">
                                    @error('stok')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input type="text" name="nama" class="form-control" value="{{ $produk->nama }}">
                                    @error('nama')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Harga Jual</label>
                                    <input type="number" name="harga_jual" class="form-control"
                                        value="{{ $produk->harga_jual }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Gambar Produk</label>
                                    <input type="file" name="gambar" class="form-control">
                                    @if ($produk->gambar)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                                                width="100">
                                        </div>
                                    @endif
                                    @error('gambar')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
