<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_count', 'emp_citizen', 'emp_country', 'emp_house', 'emp_street',
        'emp_subd', 'emp_brgy', 'emp_city', 'emp_prov', 'emp_region', 'emp_datereg',
        'emp_pob', 'emp_zip'
    ];
}
