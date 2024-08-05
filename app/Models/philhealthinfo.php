<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class philhealthinfo extends Model
{
    use HasFactory;
    protected $table = 'philhealthinfo';
    protected $primaryKey = 'empid'; // Set the primary key to empid
    public $incrementing = false; // Since empid is not auto-incrementing
    public function philhealthinfo()
    {
        return $this->belongsTo(EmpAcc::class, 'empid', 'empid');
    }
}
