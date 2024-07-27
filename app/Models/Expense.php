<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $table = 'expenses';
    protected $fillable = ['title','date','expense_category_id','team_member_id','amount','bill_file','description'];
    public function category()
    {
        return $this->belongsTo(expense_category::class, 'expense_category_id');
    }
    public function member()
    {
        return $this->belongsTo(User::class, 'team_member_id');
    }
}
