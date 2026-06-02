<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'karyawan';

    public $timestamps = false;

    // Encapsulation
    protected $fillable = ['nama', 'username', 'password', 'role'];

    // Setter untuk encapsulation password
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Getter untuk encapsulation nama
    public function getNamaAttribute($value)
    {
        return ucfirst($value);
    }
}