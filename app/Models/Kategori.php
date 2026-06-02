<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Manageable;

class Kategori extends Model implements Manageable
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['nama'];

    // Overriding metode delete()
    public function delete()
    {
        if ($this->barang()->count() > 0) {
            throw new \Exception("Kategori tidak dapat dihapus karena masih memiliki barang!");
        }
        
        return parent::delete();
    }

    public function getLogActivityDetails(): string {
        return "Kategori: " . $this->nama_kategori . " telah dimodifikasi.";
    }
}