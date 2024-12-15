<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp_work extends Model
{
    use HasFactory;
    protected $table = 'emp_work';
    protected $primaryKey = 'work_count';

    // Add fillable property
    protected $fillable = [
        'workfr',
        'workto',
        'work_pos',
        'work_dept',
        'work_salary',
        'work_salarygrade',
        'work_stat',
        'work_gov'
    ];
    public function emp_work()
    {
        return $this->belongsTo(EmpAcc::class, 'empid', 'empid');
    }
}
