<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp_mother extends Model
{
    use HasFactory;

    protected $table = 'emp_mother';
    protected $primaryKey = 'emp_count';
    public $timestamps = false;
 

    public function empMother()
    {
        return $this->belongsTo(EmpAcc::class, 'emp_count', 'emp_count');
    }
}
