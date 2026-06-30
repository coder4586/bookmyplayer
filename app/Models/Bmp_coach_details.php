<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bmp_coach_details extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'bmp_coach_details';
    public $timestamps = false;
    protected $guarded = [];

}
