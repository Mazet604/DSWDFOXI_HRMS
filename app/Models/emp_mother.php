<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpMother extends Model
{
    use HasFactory;

    protected $table = 'emp_mother'; // Set the table name
    protected $primaryKey = 'emp_count'; // Assuming the primary key is 'mother_id'
    public $incrementing = true; // Assuming 'mother_id' is auto-incrementing
    protected $casts = [
        'mother_id' => 'integer',
    ];

    public function empMother()
    {
        return $this->belongsTo(EmpAcc::class, 'emp_count', 'emp_count');
    }
}
