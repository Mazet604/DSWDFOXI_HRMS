<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp_work extends Model
{
    use HasFactory;
    protected $table = 'emp_work';
    protected $primaryKey = 'empid'; // Set the primary key to empid
    public $incrementing = false; // Since empid is not auto-incrementing
    public function emp_work()
    {
        return $this->belongsTo(EmpAcc::class, 'empid', 'empid');
    }
}
