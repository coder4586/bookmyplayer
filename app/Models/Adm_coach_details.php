<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adm_coach_details extends Model
{
    use HasFactory;
    protected $connection = 'mysql_admin';
    protected $table = 'adm_coach_details';
    public $timestamps = false;
    protected $guarded = [];
}
