<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clientService extends Model
{
    use HasFactory;
    protected $table = 'client_service';
    protected $fillable = ['service_category_id','client_id'];
}
