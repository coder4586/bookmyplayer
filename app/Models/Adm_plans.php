<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adm_plans extends Model
{
    use HasFactory;
    protected $connection = 'mysql_admin';
    protected $table = 'adm_plans';
    public $timestamps = false;
    protected $guarded = [];
}
