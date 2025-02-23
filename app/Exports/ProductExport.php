<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromQuery;

class ProductExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    private $nomor = 0;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Product::query();

        // Filter berdasarkan kategori
        if ($this->request->filled('category_id')) {
            $query->where('category_id', $this->request->category_id);
        }

        // Filter berdasarkan pencarian nama produk
        if ($this->request->filled('search')) {
            $query->where('nama', 'LIKE', '%' . $this->request->search . '%');
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            '#',
            'Kategori Produk',
            'Nama Produk',
            'Harga Beli',
            'Harga Jual',
            'Stok Produk',
            'Gambar'
        ];
    }

    public function map($produk): array
    {
        return [
            ++$this->nomor,
            $produk->category->nama,
            $produk->nama,
            $produk->harga_beli,
            $produk->harga_jual,
            $produk->stok,
            $produk->gambar
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true, 'size' => 14]],
        ];
    }
}
