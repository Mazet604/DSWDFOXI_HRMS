<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpSpouse extends Model
{
    use HasFactory;

    protected $table = 'emp_spouse'; // Set the table name
    protected $primaryKey = 'emp_count'; // Assuming the primary key is 'spouse_id'
    public $incrementing = true; // Assuming 'spouse_id' is auto-incrementing
    protected $casts = [
        'spouse_id' => 'integer',
    ];

    public function empSpouse()
    {
        return $this->belongsTo(EmpAcc::class, 'emp_count', 'emp_count');
    }
}
