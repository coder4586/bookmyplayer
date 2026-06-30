<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adm_academy_details extends Model
{
    use HasFactory;
    protected $connection = 'mysql_admin';
    protected $table = 'adm_academy_details';
    public $timestamps = false;
    protected $guarded = [];
}
