<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp_father extends Model
{
    use HasFactory;

    protected $table = 'emp_father'; // Set the table name
    protected $primaryKey = 'emp_count'; // Assuming the primary key is 'father_id'
    

    public function empFather()
    {
        return $this->belongsTo(EmpAcc::class, 'emp_count', 'emp_count');
    }
}
