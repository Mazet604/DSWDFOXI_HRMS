<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp_eligibility extends Model
{
    use HasFactory;
    protected $table = 'emp_eligibility';
    protected $primaryKey = 'empid'; // Set the primary key to empid
    public $incrementing = false; // Since empid is not auto-incrementing
    public function emp_eligibility()
    {
        return $this->belongsTo(EmpAcc::class, 'empid', 'empid');
    }
}
