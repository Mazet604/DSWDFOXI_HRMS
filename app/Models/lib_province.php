<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\AddressController;

class lib_province extends Model
{
    use HasFactory;

    protected $table = 'lib_provinces';
    protected $primaryKey = 'psgc';
    public $incrementing = false;
    protected $fillable = ['psgc', 'col_province'];
}
