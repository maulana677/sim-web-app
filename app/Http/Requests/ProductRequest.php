<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'nama' => 'required|string|max:255|unique:products,nama',
            'harga_beli' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'required|image|mimes:jpg,png|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama produk wajib diisi.',
            'nama.unique' => 'Nama produk sudah digunakan, pilih nama lain.',
            'harga_beli.required' => 'Harga beli barang wajib diisi.',
            'harga_beli.numeric' => 'Harga beli harus berupa angka.',
            'stok.required' => 'Stok barang wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'gambar.required' => 'Gambar wajib diisi.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG atau PNG.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 100KB.',
            'category_id.required' => 'Kategori wajib dipilih'
        ];
    }
}
