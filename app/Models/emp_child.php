<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp_child extends Model
{
    use HasFactory;
    protected $table = 'emp_child';
    protected $primaryKey = 'emp_count'; // Set the primary key to empid
    public $incrementing = false; // Since empid is not auto-incrementing
    public function emp_child()
    {
        return $this->belongsTo(EmpAcc::class, 'emp_count', 'emp_count');
    }
}
