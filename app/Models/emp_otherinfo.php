<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp_otherinfo extends Model
{
    use HasFactory;
    protected $table = 'emp_otherinfo';
    protected $primaryKey = 'other_count';
    protected $fillable = ['empid', 'other_count', 'other_34a', 'other_34b', 'other_34bif', 'other_35a', 'other_35aif', 'other_35b', 'other_35bif', 'other_35bfiled', 'other_35stat', 'other_36', 'other_36if', 'other_37', 'other_37if', 'other_38a', 'other_38aif', 'other_38b', 'other_39', 'other_39if', 'other_40a', 'other_40aif', 'other_40b', 'other_40bif', 'other_40c', 'other_40cif'];

    public function emp_otherinfo()
    {
        return $this->belongsTo(EmpAcc::class, 'empid', 'empid');
    }
}
