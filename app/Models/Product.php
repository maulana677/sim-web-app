<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'category_id',
        'nama',
        'harga_beli',
        'harga_jual',
        'stok',
        'gambar'
    ];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Setter otomatis menghitung harga jual (30% dari harga beli)
    public function setHargaBeliAttribute($value)
    {
        $this->attributes['harga_beli'] = $value;
        $this->attributes['harga_jual'] = $value + ($value * 0.30);
    }
}
