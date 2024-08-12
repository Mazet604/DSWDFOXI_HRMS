<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpAddress extends Model
{
    use HasFactory;

    protected $table = 'emp_address';
    protected $primaryKey = 'emp_count';

    protected $fillable = [
        'emp_count', 'emp_citizen', 'emp_house', 'emp_street',
        'emp_subd', 'emp_brgy', 'emp_city', 'emp_prov', 'emp_region', 'emp_datereg',
        'emp_pob', 'emp_zip'
    ];

    public function Address()
    {
        return $this->belongsTo(EmpAddress::class, 'emp_count', 'emp_count');
    }

}
