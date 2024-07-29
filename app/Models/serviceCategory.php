<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class serviceCategory extends Model
{
    use HasFactory;
    protected $table = 'service_categories';
    protected $fillable = ['name'];
    // public function services()
    // {
    //     return $this->hasMany(Product::class);
    // }
}
