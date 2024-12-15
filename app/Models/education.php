<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class education extends Model
{
    use HasFactory;

    protected $table = 'education';
    protected $primaryKey = 'educ_count';

    // Add fillable property
    protected $fillable = [
        'educ_count',
        'empid',
        'educ_level',
        'educ_school',
        'educ_degree',
        'educ_from',
        'educ_year_grad',
        'educ_academic_honor',
        'educ_hl_earned',
    ];

    public function Education()
    {
        return $this->belongsTo(EmpAcc::class, 'empid', 'empid');
    }
}
