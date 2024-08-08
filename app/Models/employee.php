<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    use HasFactory;

    protected $table = 'employee';
    protected $primaryKey = 'empid'; // Set the primary key to empid
    public $incrementing = false; // Since empid is not auto-incrementing
    protected $casts = ['empid' => 'string',];
    
    // Define the relationship with the EmpAcc model
    public function empAcc()
    {
        return $this->belongsTo(EmpAcc::class, 'empid', 'empid');
    }

    public function PersonalInfo()
    {
        return $this->belongsTo(EmpAcc::class, 'empid', 'empid');
    }

    public function SecurityandContact()
    {
        return $this->belongsTo(EmpAcc::class, 'empid', 'empid');
    }
}
