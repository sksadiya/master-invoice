<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['first_name','last_name','business','email','contact','alter_contact','website','country_id','state_id','city_id','postal_code','Address','Notes','GST'];
}
