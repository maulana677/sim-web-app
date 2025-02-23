@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Produk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.produk.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Produk</a></div>
                <div class="breadcrumb-item">Semua Produk</div>
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Semua Produk</h2>
            <p class="section-lead">
                Halaman ini menampilkan semua data produk.
            </p>

            <form action="{{ route('admin.produk.index') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <select name="category_id" class="form-control">
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ request('category_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari Produk..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Cari</button>
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Reset</a>

                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Daftar Produk</h4>
                            <div class="card-header-action">
                                <a href="{{ route('produk.xls', request()->all()) }}" class="btn btn-success">Export
                                    Excel</a>
                                <a href="{{ route('admin.produk.create') }}" class="btn btn-success">Tambah Produk <i
                                        class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table">
                                    <thead>
                                        <tr>
                                            <th class="text-left">No</th>
                                            <th>Image</th>
                                            <th>Nama Produk</th>
                                            <th>Kategori Produk</th>
                                            <th>Harga Beli (Rp)</th>
                                            <th>Harga Jual (Rp)</th>
                                            <th class="text-center">Stok Produk</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($produk as $item)
                                            <tr>
                                                <td class="text-left">{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="Produk"
                                                        width="50">
                                                </td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->category->nama }}</td>
                                                <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                                <td class="text-center">{{ $item->stok }}</td>
                                                <td>
                                                    <a href="{{ route('admin.produk.edit', $item->id) }}"
                                                        class="btn btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.produk.destroy', $item->id) }}"
                                                        class="btn btn-danger delete-item">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "pageLength": 5,
                "lengthMenu": [5, 10, 25, 50],
                "searching": true,
                "paging": true,
                "ordering": true,
                "info": true,
                "language": {
                    "emptyTable": "Tidak ada data yang tersedia"
                },
                "destroy": true,
            });
        });
    </script>
@endpush
