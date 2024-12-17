<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp_father extends Model
{
    use HasFactory;

    protected $table = 'emp_father';

    protected $primaryKey = 'emp_count';

    // Add fillable property
    protected $fillable = [
        'emp_count',
        'father_lname',
        'father_fname',
        'father_mname',
        'father_xname'
    ];

    public function empFather()
    {
        return $this->belongsTo(Employee::class, 'emp_count', 'emp_count');
    }
}
