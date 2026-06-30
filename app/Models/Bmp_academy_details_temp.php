<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bmp_academy_details_temp extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'bmp_academy_details_temp';
    protected $guarded = [];
    public $timestamps = false;
}
