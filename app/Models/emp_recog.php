<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp_recog extends Model
{
    use HasFactory;
    protected $table = 'emp_recog';
    protected $primaryKey = 'empid'; // Set the primary key to empid
    public $incrementing = false; // Since empid is not auto-incrementing
    public function emp_recog()
    {
        return $this->belongsTo(EmpAcc::class, 'empid', 'empid');
    }
}
