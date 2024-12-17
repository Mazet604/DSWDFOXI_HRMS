<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tininfo extends Model
{
    use HasFactory;
    protected $table = 'tininfo';
    protected $primaryKey = 'tin_count';

    protected $fillable = [
        'empid',      // Add this field
        'tin_id',    // Assuming this is another field in the table
    ];
    public function tininfo()
    {
        return $this->belongsTo(EmpAcc::class, 'empid', 'empid');
    }
}
