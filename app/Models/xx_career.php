<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class xx_career extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'xx_career';
    protected $guarded = [];
    public $timestamps = false;
}
