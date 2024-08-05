<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp_learning extends Model
{
    use HasFactory;
    protected $table = 'emp_learning';
    protected $primaryKey = 'empid'; // Set the primary key to empid
    public $incrementing = false; // Since empid is not auto-incrementing
    public function emp_learning()
    {
        return $this->belongsTo(EmpAcc::class, 'empid', 'empid');
    }
}
