<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class philhealthinfo extends Model
{
    use HasFactory;
    protected $table = 'philhealthinfo';
    protected $primaryKey = 'phl_count';

    protected $fillable = [
        'empid',      // Add this field
        'ph_lid',    // Assuming this is another field in the table
    ];

    public function philhealthinfo()
    {
        return $this->belongsTo(EmpAcc::class, 'empid', 'empid');
    }
}
