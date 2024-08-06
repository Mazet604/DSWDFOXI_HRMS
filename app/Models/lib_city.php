<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\AddressController;

class lib_city extends Model
{
    use HasFactory;

    protected $table = 'lib_cities';
    protected $primaryKey = 'psgc';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = ['psgc', 'col_citymuni'];
}
