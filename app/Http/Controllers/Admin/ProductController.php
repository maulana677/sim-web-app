<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductExport;
use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter berdasarkan kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Pencarian berdasarkan nama produk
        if ($request->filled('search')) {
            $query->where('nama', 'ILIKE', '%' . $request->search . '%');
        }

        $kategori = Category::all();
        $produk = $query->latest()->paginate(10);
        return view('admin.produk.index', compact('produk', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Category::all();
        return view('admin.produk.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // Hitung harga jual otomatis (30% dari harga beli)
        $hargaJual = $request->harga_beli + ($request->harga_beli * 0.3);

        // Inisialisasi path gambar
        $thumbnailPath = null;

        // Jika ada file gambar yang diunggah
        if ($request->hasFile('gambar')) {
            $gambarFile = $request->file('gambar');
            $gambarFileName = Str::random(40) . '.' . $gambarFile->getClientOriginalExtension();
            $thumbnailPath = $gambarFile->storeAs('products', $gambarFileName, 'public');
        }

        // Simpan data produk ke database
        $product = new Product();
        $product->category_id = $request->category_id; // Simpan category_id sesuai dengan migration
        $product->nama = $request->nama;
        $product->harga_beli = $request->harga_beli;
        $product->harga_jual = $hargaJual; // Harga jual dihitung otomatis
        $product->stok = $request->stok;
        $product->gambar = $thumbnailPath;
        $product->save();

        // Redirect dengan notifikasi sukses
        toastr()->success('Produk berhasil ditambahkan.');
        return redirect()->route('admin.produk.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produk = Product::findOrFail($id);
        $kategori = Category::all();

        return view('admin.produk.edit', compact('produk', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Hitung harga jual otomatis (30% dari harga beli)
        $hargaJual = $request->harga_beli + ($request->harga_beli * 0.3);

        // Cek jika ada file gambar baru yang diunggah
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }

            // Simpan gambar baru
            $gambarFile = $request->file('gambar');
            $gambarFileName = Str::random(40) . '.' . $gambarFile->getClientOriginalExtension();
            $product->gambar = $gambarFile->storeAs('products', $gambarFileName, 'public');
        }

        // Update data produk
        $product->category_id = $request->category_id;
        $product->nama = $request->nama;
        $product->harga_beli = $request->harga_beli;
        $product->harga_jual = $hargaJual;
        $product->stok = $request->stok;
        $product->save();

        // Redirect dengan notifikasi sukses
        toastr()->success('Produk berhasil diperbarui.');
        return redirect()->route('admin.produk.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Mencari data produk berdasarkan ID
            $product = Product::findOrFail($id);

            // Menghapus file gambar jika ada dan file tersebut ada di penyimpanan
            if ($product->gambar && Storage::disk('public')->exists($product->gambar)) {
                Storage::disk('public')->delete($product->gambar);
            }

            // Menghapus data produk dari database
            $product->delete();

            // Mengembalikan respon sukses
            return response(['status' => 'success', 'message' => 'Produk berhasil dihapus!']);
        } catch (\Throwable $th) {
            // Menangani kesalahan dan mengembalikan respon error
            return response(['status' => 'error', 'message' => 'Terjadi kesalahan saat menghapus produk!']);
        }
    }

    public function export(Request $request)
    {
        return Excel::download(new ProductExport($request), 'produk.xlsx');
    }
}
