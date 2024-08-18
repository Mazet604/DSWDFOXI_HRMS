<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp_mother extends Model
{
    use HasFactory;

    protected $table = 'emp_mother'; // Set the table name
    protected $primaryKey = 'emp_count'; // Assuming the primary key is 'mother_id'
 

    public function empMother()
    {
        return $this->belongsTo(EmpAcc::class, 'emp_count', 'emp_count');
    }
}
