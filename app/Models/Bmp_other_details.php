<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bmp_other_details extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'bmp_other_details';
    protected $guarded = [];
    public $timestamps = false;
}
