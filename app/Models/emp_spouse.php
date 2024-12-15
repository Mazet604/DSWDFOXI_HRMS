<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp_spouse extends Model
{
    use HasFactory;

    protected $table = 'emp_spouse';
    protected $primaryKey = 'emp_count';

    // Add fillable property
    protected $fillable = [
        'spouse_lname',
        'spouse_fname',
        'spouse_mname',
        'spouse_xname',
        'spouse_occup',
        'spouse_office',
        'spouse_busadd',
        'spouse_tel'
    ];
    public function empSpouse()
    {
        return $this->belongsTo(EmpAcc::class, 'emp_count', 'emp_count');
    }
}
