<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Bidang extends Model
{
    public function users()
{
    return $this->hasMany(User::class);
}
    protected $fillable = ['nama_bidang'];
}
